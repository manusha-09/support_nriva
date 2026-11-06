@php
    // Keep the controller's committee-scoped ticket list unchanged.
    $data = $datalist;
    $deskTitle = 'All Tickets';
    $deskListUrl = url('user_committee');
    // Supply the same display/edit data used by the My Tickets workspace.
    $department = \App\Models\department::all();
    $categories = \App\Models\Categories::all();
    $chapters = \App\Models\chapters::all();
    $comments = collect();
@endphp
@include('tickets.member-workspace')