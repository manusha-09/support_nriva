<?php

namespace App\Services;

use App\Models\SupportMailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SupportTicketMail
{
    private static $lastSandboxSendAt;

    private static function paceSandboxMail()
    {
        // Sandbox plans limit bursts; production SMTP delivery is unaffected.
        if (Mail::getFacadeRoot() instanceof \Illuminate\Support\Testing\Fakes\MailFake || config('mail.default') !== 'smtp' || config('mail.mailers.smtp.host') !== 'sandbox.smtp.mailtrap.io') {
            return;
        }
        if (self::$lastSandboxSendAt !== null) {
            $remaining = 12 - (microtime(true) - self::$lastSandboxSendAt);
            if ($remaining > 0) { usleep((int) ($remaining * 1000000)); }
        }
        self::$lastSandboxSendAt = microtime(true);
    }

    public static function addresses($value)
    {
        return array_values(array_unique(array_filter(array_map(function ($email) {
            return strtolower(trim($email));
        }, explode(',', (string) $value)), function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        })));
    }

    public static function targets($ticket)
    {
        $emails = [];
        foreach (['committee' => $ticket->department, 'chapter' => $ticket->c_id] as $type => $group) {
            if (!$group) { continue; }
            $userId = $ticket->{$type === 'committee' ? 'assigned_committee_user_id' : 'assigned_chapter_user_id'};
            if ($userId) {
                $emails[] = DB::table('users')->where('id', $userId)->whereNull('deleted_at')->value('email');
            } else {
                $emails[] = DB::table($type === 'committee' ? 'committees' : 'chapters')
                    ->where($type === 'committee' ? 'name' : 'id', $group)->whereNull('deleted_at')->value('email');
            }
        }
        return self::addresses(implode(',', $emails));
    }

    public static function send($ticket, $event, $changes = '')
    {
        try {
            $template = SupportMailTemplate::where('type', 'support_ticket_'.$event)->where('status', 1)->first();
            if (!$template) { return; }
            $actor = auth()->user();
            $creatorId = $ticket->ticket_created_by_id ?: $ticket->created_by;
            $creator = $creatorId ? DB::table('users')->where('id', $creatorId)->first() : null;
            $creatorEmails = self::addresses($creator ? $creator->email : $ticket->email);
            $targets = self::targets($ticket);
            // Both audiences receive creation and update messages, using their own body.
            $recipients = array_merge($targets, $creatorEmails);
            $recipients = array_unique(array_merge($recipients, self::addresses($template->to_email)));
            $cc = self::addresses($template->cc_emails);
            // Keep configured CC recipients in CC even if also a ticket target.
            $recipients = array_values(array_diff($recipients, $cc));
            if (!$recipients && !$cc) { return; }
            $values = [
                'ticket_id' => $ticket->ticket_unique_id ?: $ticket->id, 'subject' => $ticket->subject,
                'creator_name' => $ticket->name, 'creator_email' => implode(', ', $creatorEmails),
                'committee' => $ticket->department, 'chapter' => $ticket->c_id ? DB::table('chapters')->where('id', $ticket->c_id)->value('name') : '',
                'status' => $ticket->issue_status, 'priority' => $ticket->issue_priority,
                'description' => strip_tags((string) $ticket->description), 'changes' => $changes,
                'actor_name' => $actor ? $actor->name : $ticket->name,
                'ticket_url' => route('ticketdetails', $ticket->id),
            ];
            foreach ($recipients ?: [null] as $recipient) {
                $values['recipient_name'] = in_array($recipient, $creatorEmails) ? $ticket->name : 'Support team';
                $values['assignment_type'] = 'assigned target';
                $values['assignment_name'] = '';
                foreach (['committee' => $ticket->department, 'chapter' => $ticket->c_id] as $type => $group) {
                    if (!$group) { continue; }
                    $assignedId = $ticket->{$type === 'committee' ? 'assigned_committee_user_id' : 'assigned_chapter_user_id'};
                    $targetEmail = $assignedId
                        ? DB::table('users')->where('id', $assignedId)->value('email')
                        : DB::table($type === 'committee' ? 'committees' : 'chapters')->where($type === 'committee' ? 'name' : 'id', $group)->value('email');
                    if (in_array($recipient, self::addresses($targetEmail))) {
                        $values['assignment_type'] = $assignedId ? 'member' : $type;
                        $values['assignment_name'] = $assignedId ? optional(\App\Models\User::find($assignedId))->name : ($type === 'committee' ? $group : $values['chapter']);
                        $values['recipient_name'] = $values['assignment_name'];
                        break;
                    }
                }
                $body = SupportMailTemplate::audienceBody($template->template, in_array($recipient, $creatorEmails) ? 'creator' : 'target', $values['assignment_type']);
                $html = []; $plain = [];
                foreach ($values as $key => $value) {
                    $plain['{{'.$key.'}}'] = (string) $value;
                    $html['{{'.$key.'}}'] = nl2br(e((string) $value));
                }
                $subject = str_replace(["\r", "\n"], ' ', strtr($template->subject, $plain));
                $message = (new \App\Mail\SupportTemplateMail(strtr($body, $html)))->subject($subject);
                if ($recipient) { $message->to($recipient); }
                if ($cc) { $message->cc($cc); }
                if ($template->from_email) { $message->from($template->from_email); }
                self::paceSandboxMail();
                Mail::send($message);
                self::$lastSandboxSendAt = microtime(true);
            }
        } catch (\Throwable $exception) {
            Log::error('Ticket email delivery failed', ['ticket_id' => $ticket->id, 'event' => $event, 'error' => $exception->getMessage()]);
        }
    }
}
