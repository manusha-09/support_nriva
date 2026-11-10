<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TicketAssignees
{
    public static function members($type, $group)
    {
        $committee = $type === 'committee';
        $query = DB::table(($committee ? 'committeemembers' : 'chapterleads').' as membership')
            ->join('users as member', 'member.id', '=', 'membership.user_id')
            ->join('roles as role', 'role.id', '=', 'membership.role_id')
            ->whereIn('membership.year', DB::table('years')->where('default_year', 1)->select('id'))
            ->whereNull('member.deleted_at');

        if ($committee) {
            $query->join('committees as assigned_group', 'assigned_group.id', '=', 'membership.committee_id')
                ->where('membership.status', 1)->where('assigned_group.name', $group);
        } else {
            $query->join('chapters as assigned_group', 'assigned_group.id', '=', 'membership.chapter_id')
                ->where('assigned_group.id', $group);
        }

        return $query->where('assigned_group.status', 1)->whereNull('assigned_group.deleted_at')
            ->orderBy('member.first_name')->orderBy('member.last_name')
            ->get(['membership.id', 'member.id as user_id', 'member.first_name', 'member.last_name', 'role.name as role']);
    }
}
