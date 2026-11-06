@php($deskFirst = $deskTickets[0] ?? null)
<aside class="desk-properties" aria-label="Selected ticket properties">
    <div class="desk-panel-title">Ticket Properties <i class="fas fa-sliders-h" aria-hidden="true"></i></div>
    <div class="desk-property-content">
        <section class="desk-property-card"><h2>Contact Info</h2>
            <div class="desk-contact"><span class="desk-avatar" data-desk-avatar>{{ strtoupper(substr($deskFirst->name ?? 'T', 0, 1)) }}</span><div><strong data-desk="name">{{ $deskFirst->name ?? 'Select a ticket' }}</strong><span>Ticket requester</span></div></div>
            <dl><dt>Email</dt><dd data-desk="email">{{ $deskFirst->email ?? 'Not provided' }}</dd></dl>
        </section>
        <section class="desk-property-card"><h2>Key Information</h2><dl>
            <dt>Ticket ID</dt><dd data-desk="ticket">{{ $deskFirst->ticket_unique_id ?? '-' }}</dd>
            <dt>Status</dt><dd><span class="desk-status" data-desk="status">{{ $deskFirst->issue_status ?? '-' }}</span><div data-desk-status-control></div></dd>
            <dt>Priority</dt><dd data-desk="priority">{{ $deskFirst->issue_priority ?? '-' }}</dd>
            <dt>Committee</dt><dd data-desk="department">{{ $deskFirst->department ?? '-' }}</dd>
            <dt>Category</dt><dd data-desk="category">{{ $deskFirst->category ?? '-' }}</dd>
            <dt>Chapter</dt><dd data-desk="chapter">{{ $deskFirst->chapter_name ?? '-' }}</dd>
            <dt>Created time</dt><dd data-desk="created">{{ $deskFirst->created_at ?? '-' }}</dd>
            <dt>Last updated</dt><dd data-desk="updated">{{ $deskFirst->updated_at ?? '-' }}</dd>
        </dl></section>
    </div>
</aside>
@if(count($deskTickets) === 0)
<div class="desk-empty"><i class="far fa-check-circle" aria-hidden="true"></i><h2>No tickets in this view</h2><p>Try another status or reset your filters.</p></div>
@endif