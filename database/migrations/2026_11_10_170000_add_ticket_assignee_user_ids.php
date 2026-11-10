<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTicketAssigneeUserIds extends Migration
{
    public function up()
    {
        Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_committee_user_id')->nullable();
            $table->unsignedBigInteger('assigned_chapter_user_id')->nullable();
        });
        foreach (DB::table('tbl_ticketing_system_tickets')->get() as $ticket) {
            $updates = [];
            if ($ticket->assigned_committee_member_id !== null) {
                $users = DB::table('committeemembers as m')->join('committees as c', 'c.id', '=', 'm.committee_id')
                    ->where('m.id', $ticket->assigned_committee_member_id)->where('c.name', $ticket->department)
                    ->distinct()->pluck('m.user_id');
                if ($users->count() === 1) $updates['assigned_committee_user_id'] = $users->first();
            }
            if ($ticket->assigned_chapter_lead_id !== null) {
                $users = DB::table('chapterleads')->where('id', $ticket->assigned_chapter_lead_id)
                    ->where('chapter_id', $ticket->c_id)->distinct()->pluck('user_id');
                if ($users->count() === 1) $updates['assigned_chapter_user_id'] = $users->first();
            }
            if ($updates) DB::table('tbl_ticketing_system_tickets')->where('id', $ticket->id)->update($updates);
        }
    }

    public function down()
    {
        Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
            $table->dropColumn(['assigned_committee_user_id', 'assigned_chapter_user_id']);
        });
    }
}
