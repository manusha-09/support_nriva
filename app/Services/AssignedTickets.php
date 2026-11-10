<?php

namespace App\Services;

use App\Models\tickets;
use Illuminate\Support\Facades\DB;

class AssignedTickets
{
    public static function query($user, $scope)
    {
        $query = tickets::query();
        $years = DB::table('years')->where('default_year', 1)->select('id');
        if ($scope === 'committee') {
            $committees = DB::table('committeemembers as membership')
                ->join('committees as committee', 'committee.id', '=', 'membership.committee_id')
                ->where('membership.user_id', $user->id)->where('membership.status', 1)
                ->whereIn('membership.year', $years)
                ->where('committee.status', 1)->whereNull('committee.deleted_at')
                ->select('committee.name');
            return $query->whereIn('department', $committees);
        }
        if ($scope === 'chapter') {
            $chapterIds = DB::table('chapters')->where('status', 1)->whereNull('deleted_at')
                ->where(function ($chapters) use ($user, $years) {
                    $chapters->where('id', $user->chapter_id ?: 0)
                        ->orWhereIn('id', DB::table('chapterleads')->where('user_id', $user->id)
                            ->whereIn('year', $years)->select('chapter_id'));
                })->select('id');
            return $query->whereIn('c_id', $chapterIds);
        }
        return $query->where(function ($assigned) use ($user) {
            $assigned->where('assigned_committee_user_id', $user->id)
                ->orWhere('assigned_chapter_user_id', $user->id);
        });
    }
}
