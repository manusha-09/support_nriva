<?php

namespace App\Http\Controllers;

use App\Services\TicketSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketSettingsController extends Controller
{
    public function edit()
    {
        return view('tickets.settings', [
            'memberAssignmentEnabled' => TicketSettings::memberAssignmentEnabled(),
            'bothAssignmentEnabled' => TicketSettings::bothAssignmentEnabled(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'member_assignment_enabled' => 'required_without:both_assignment_enabled|filled|in:0,1',
            'both_assignment_enabled' => 'required_without:member_assignment_enabled|filled|in:0,1',
        ]);
        if ($request->has('member_assignment_enabled')) {
            DB::table('tbl_ticketing_system_settings')->updateOrInsert(
                ['key' => 'member_assignment_enabled'],
                ['value' => (string) $request->input('member_assignment_enabled')]
            );
        }

        if ($request->has('both_assignment_enabled')) {
            DB::table('tbl_ticketing_system_settings')->updateOrInsert(
                ['key' => 'both_assignment_enabled'],
                ['value' => (string) $request->input('both_assignment_enabled')]
            );
        }

        return redirect()->route('ticket.settings')->with('success', 'Ticket settings have been saved.');
    }
}
