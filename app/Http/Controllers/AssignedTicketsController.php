<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\chapters;
use App\Models\department;
use App\Services\AssignedTickets;
use Illuminate\Http\Request;

class AssignedTicketsController extends Controller
{
    public function index(Request $request, $scope)
    {
        $titles = ['committee' => 'My Committee Tickets', 'chapter' => 'My Chapter Tickets', 'me' => 'To Me'];
        abort_unless(isset($titles[$scope]), 404);
        $query = AssignedTickets::query($request->user(), $scope);
        if ($request->filled('priority')) {
            $query->where('issue_priority', $request->priority);
        }
        if ($request->input('status', 'All') !== 'All') {
            $query->where('issue_status', $request->input('status'));
        }
        return view('tickets.member-workspace', [
            'data' => $query->orderBy('id', 'desc')->get(),
            'deskTitle' => $titles[$scope],
            'deskListUrl' => route('assigned.tickets', $scope),
            'deskDefaultStatus' => 'All',
            'department' => department::all(),
            'chapters' => chapters::all(),
            'categories' => Categories::all(),
            'comments' => collect(),
        ]);
    }
}
