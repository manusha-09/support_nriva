<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TicketSettings
{
    public static function bothAssignmentEnabled()
    {
        $value = DB::table('tbl_ticketing_system_settings')
            ->where('key', 'both_assignment_enabled')->value('value');

        return $value === null || $value === '1';
    }

    public static function memberAssignmentEnabled()
    {
        $value = DB::table('tbl_ticketing_system_settings')
            ->where('key', 'member_assignment_enabled')->value('value');

        return $value === null || $value === '1';
    }
}
