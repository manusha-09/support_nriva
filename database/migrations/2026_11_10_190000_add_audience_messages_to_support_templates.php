<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAudienceMessagesToSupportTemplates extends Migration
{
    public function up()
    {
        $templates = DB::table('mail_templates')->whereIn('type', ['support_ticket_created', 'support_ticket_updated'])->whereNull('deleted_at')->get();
        foreach ($templates as $template) {
            $bodies = [];
            foreach (['creator', 'target'] as $audience) {
                $body = (string) $template->template;
                foreach (['creator', 'target'] as $section) {
                    $body = preg_replace_callback('~{{#'.$section.'}}(.*?){{/'.$section.'}}~s', function ($match) use ($section, $audience) {
                        return $section === $audience ? $match[1] : '';
                    }, $body);
                }
                if ($template->type === 'support_ticket_created') {
                    $intro = $audience === 'creator'
                        ? '<p>Your ticket {{ticket_id}} has been submitted. The assigned support target has been notified.</p>'
                        : '<p>A new support ticket {{ticket_id}} has been assigned to {{assignment_type}} {{assignment_name}}. Please review the request from {{creator_name}}.</p>';
                } else {
                    $intro = $audience === 'creator'
                        ? '<p>Your ticket {{ticket_id}} has been updated by {{actor_name}}. Please review the latest status or comment below.</p>'
                        : '<p>{{creator_name}} has updated ticket {{ticket_id}} assigned to {{assignment_type}} {{assignment_name}}. Please review the changes below.</p>';
                }
                $bodies[] = '{{#'.$audience.'}}'.$intro.$body.'{{/'.$audience.'}}';
            }
            DB::table('mail_templates')->where('id', $template->id)->update(['template' => implode('', $bodies), 'updated_at' => now()]);
        }
    }

    public function down()
    {
        // Preserve admin-editable content in the shared NRIVA table.
    }
}
