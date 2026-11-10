@include('navbar')
@include('sidemenu')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1 class="h4">Settings</h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card mb-4" style="max-width: 760px;">
                <div class="card-header"><h2 class="card-title">Individual member assignment</h2></div>
                <form action="{{ route('ticket.settings.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <label for="member-assignment-enabled">I want to assign it to a particular member</label>
                        <p class="text-muted">Show or hide the optional member assignment checkbox for committees and chapters in Create Ticket. This applies to all users.</p>
                        <select id="member-assignment-enabled" name="member_assignment_enabled" class="form-control" style="max-width: 200px;">
                            <option value="1" {{ (string) old('member_assignment_enabled', $memberAssignmentEnabled ? '1' : '0') === '1' ? 'selected' : '' }}>Show</option>
                            <option value="0" {{ (string) old('member_assignment_enabled', $memberAssignmentEnabled ? '1' : '0') === '0' ? 'selected' : '' }}>Hide</option>
                        </select>
                        @error('member_assignment_enabled')<p class="text-danger mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="card-footer"><button type="submit" class="btn btn-primary">Save Member Assignment</button></div>
                </form>
            </div>
            <div class="card mt-4 mb-4" style="max-width: 760px;">
                <div class="card-header"><h2 class="card-title">Both committee and chapter assignment</h2></div>
                <form action="{{ route('ticket.settings.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <label for="both-assignment-enabled">Show the Both option in Create Ticket</label>
                        <p class="text-muted">Show or hide the Both radio option in Create Ticket. Committee and Chapter remain available.</p>
                        <select id="both-assignment-enabled" name="both_assignment_enabled" class="form-control" style="max-width: 200px;">
                            <option value="1" {{ (string) old('both_assignment_enabled', $bothAssignmentEnabled ? '1' : '0') === '1' ? 'selected' : '' }}>Show</option>
                            <option value="0" {{ (string) old('both_assignment_enabled', $bothAssignmentEnabled ? '1' : '0') === '0' ? 'selected' : '' }}>Hide</option>
                        </select>
                        @error('both_assignment_enabled')<p class="text-danger mt-2">{{ $message }}</p>@enderror
                        <p class="small text-muted mt-3 mb-0">These settings apply to new tickets. Existing ticket assignments are preserved.</p>
                    </div>
                    <div class="card-footer"><button type="submit" class="btn btn-primary">Save Both Option</button></div>
                </form>
            </div>
        </div>
    </section>
</div>
@include('categories.script')
</div>
</body>
</html>
