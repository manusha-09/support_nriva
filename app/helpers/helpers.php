 
<?php

use App\Models\department;
use App\Models\tickets;

function is_user_committee()
{
    if (!Auth::check()) {
        return false;
    }

    return DB::table('committeemembers as membership')
        ->join('committees as committee', 'committee.id', '=', 'membership.committee_id')
        ->where('membership.user_id', Auth::id())
        ->where('membership.status', 1)
        ->where('committee.status', 1)
        ->exists();

         
}
