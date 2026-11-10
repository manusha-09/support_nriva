<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionalTicketAssignees extends Migration
{
    public function up()
    {
        Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_committee_member_id')->nullable();
            $table->unsignedBigInteger('assigned_chapter_lead_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
            $table->dropColumn(['assigned_committee_member_id', 'assigned_chapter_lead_id']);
        });
    }
}
