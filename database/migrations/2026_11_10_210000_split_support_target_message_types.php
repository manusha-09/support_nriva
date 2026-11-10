<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\SupportMailTemplate;

class SplitSupportTargetMessageTypes extends Migration
{
    public function up()
    {
        foreach (DB::table('mail_templates')->whereIn('type', array_keys(SupportMailTemplate::EVENTS))->whereNull('deleted_at')->get() as $template) {
            if (strpos((string) $template->template, '{{#committee}}') !== false) { continue; }
            $creator = SupportMailTemplate::audienceBody($template->template, 'creator');
            $target = SupportMailTemplate::audienceBody($template->template, 'target');
            $bodies = '';
            foreach (['committee', 'chapter', 'member'] as $type) {
                if ($template->type === 'support_ticket_created') {
                    $intro = [
                        'committee' => '<p>A new support request has been assigned to the {{assignment_name}} committee. Please coordinate a response for {{creator_name}}.</p>',
                        'chapter' => '<p>A new support request has been assigned to the {{assignment_name}} chapter. Please review the chapter request from {{creator_name}}.</p>',
                        'member' => '<p>Hello {{recipient_name}}, this support ticket has been assigned directly to you. Please review the request from {{creator_name}}.</p>',
                    ][$type];
                } else {
                    $intro = [
                        'committee' => '<p>The support ticket assigned to the {{assignment_name}} committee has a new update from {{actor_name}}. Please review the committee ticket changes below.</p>',
                        'chapter' => '<p>The support ticket assigned to the {{assignment_name}} chapter has a new update from {{actor_name}}. Please review the chapter ticket changes below.</p>',
                        'member' => '<p>Hello {{recipient_name}}, the ticket assigned directly to you has been updated by {{actor_name}}. Please review the latest comment or status below.</p>',
                    ][$type];
                }
                $bodies .= '{{#'.$type.'}}'.$intro.$target.'{{/'.$type.'}}';
            }
            DB::table('mail_templates')->where('id', $template->id)->update([
                'template' => '{{#creator}}'.$creator.'{{/creator}}{{#target}}'.$bodies.'{{/target}}', 'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        // Preserve the shared templates and any subsequent admin edits.
    }
}
