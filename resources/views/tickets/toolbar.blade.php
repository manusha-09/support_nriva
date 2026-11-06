<link rel="stylesheet" href="{{ asset('dist/css/ticket-workspace.css') . '?v=' . filemtime(public_path('dist/css/ticket-workspace.css')) }}">
<div class="desk-toolbar" data-storage-url="{{ asset('storage') }}/">
    <div><span class="desk-eyebrow">SUPPORT WORKSPACE</span><h1>{{ $deskTitle }} <span class="desk-count">{{ count($deskTickets) }}</span></h1></div>
    <a class="desk-add" href="{{ route('createticket') }}"><i class="fas fa-plus" aria-hidden="true"></i> Add Ticket</a>
</div>