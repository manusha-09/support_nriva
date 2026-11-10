<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedSupportMailTemplates extends Migration
{
    public function up()
    {
        foreach (['created' => 'Ticket Created', 'updated' => 'Ticket Updated'] as $event => $title) {
            if (DB::table('mail_templates')->where('type', 'support_ticket_'.$event)->whereNull('deleted_at')->exists()) {
                continue;
            }
            DB::table('mail_templates')->insert([
                'type' => 'support_ticket_'.$event, 'name' => $title, 'status' => 1,
                'subject' => '{{ticket_id}}: '.$title.' - {{subject}}',
                'cc_emails' => 'technology@nriva.org',
                'template' => '<p>Hello {{recipient_name}},</p><p>{{#creator}}Your support ticket has been received.{{/creator}}{{#target}}A ticket requires your attention.{{/target}}</p><p>Ticket: {{ticket_id}}<br>Subject: {{subject}}<br>Creator: {{creator_name}} ({{creator_email}})<br>Committee: {{committee}}<br>Chapter: {{chapter}}<br>Status: {{status}}<br>Priority: {{priority}}</p><p>{{description}}</p><p>Changed by: {{actor_name}}</p><p>{{changes}}</p><p><a href="{{ticket_url}}">View ticket</a></p>',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        // Shared, admin-editable templates are deliberately preserved.
    }
}
