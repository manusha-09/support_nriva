<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSupportTargetNotificationWording extends Migration
{
    public function up()
    {
        // Update only the previously supplied default sentence; retain admin edits.
        $old = '{{creator_name}} has updated ticket {{ticket_id}} assigned to {{assignment_type}} {{assignment_name}}. Please review the changes below.';
        $new = '{{actor_name}} has updated ticket {{ticket_id}} assigned to {{assignment_type}} {{assignment_name}}. Please review the changes below.';
        foreach (DB::table('mail_templates')->where('type', 'support_ticket_updated')->whereNull('deleted_at')->get() as $template) {
            if (strpos((string) $template->template, $old) !== false) {
                DB::table('mail_templates')->where('id', $template->id)->update([
                    'template' => str_replace($old, $new, $template->template), 'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        // Preserve any later admin edits to this shared template.
    }
}
