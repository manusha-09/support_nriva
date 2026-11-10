<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketingSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_ticketing_system_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_ticketing_system_settings');
    }
}
