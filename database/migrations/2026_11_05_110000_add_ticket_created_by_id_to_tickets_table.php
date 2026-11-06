<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketCreatedByIdToTicketsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('tbl_ticketing_system_tickets', 'ticket_created_by_id')) {
            Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
                $table->unsignedBigInteger('ticket_created_by_id')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('tbl_ticketing_system_tickets', 'ticket_created_by_id')) {
            Schema::table('tbl_ticketing_system_tickets', function (Blueprint $table) {
                $table->dropColumn('ticket_created_by_id');
            });
        }
    }
}