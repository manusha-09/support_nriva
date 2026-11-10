@php
    $assignmentType = old('assignment_type', old('c_id') ? (old('department') ? 'both' : 'chapter') : 'committee');
    $bothAssignmentEnabled = \App\Services\TicketSettings::bothAssignmentEnabled();
    if (!$bothAssignmentEnabled && $assignmentType === 'both') {
        $assignmentType = 'committee';
    }
@endphp
<div class="col-12">
    <fieldset class="ticket-assignment" data-ticket-assignment data-members-url="{{ route('ticket.assignees') }}">
        <legend>Assign to <span class="text-danger">*</span></legend>
        <p class="ticket-assignment-help">{{ $bothAssignmentEnabled ? 'Choose a committee, a chapter, or both for this ticket.' : 'Choose a committee or chapter for this ticket.' }}</p>
        <div class="ticket-assignment-options">
            @foreach(['committee' => 'Committee', 'chapter' => 'Chapter', 'both' => 'Both'] as $value => $label)
                @if($value !== 'both' || $bothAssignmentEnabled)
                <label class="ticket-assignment-option">
                    <input type="radio" name="assignment_type" value="{{ $value }}" {{ $assignmentType === $value ? 'checked' : '' }} required>
                    <span>{{ $label }}</span>
                </label>
                @endif
            @endforeach
        </div>
        @error('assignment_type')<p class="text-danger small" role="alert">{{ $message }}</p>@enderror
        <div class="ticket-assignment-field" data-assignment-field="committee" {{ $assignmentType === 'chapter' ? 'hidden' : '' }}>
            <label for="department">Committee <span class="text-danger">*</span></label>
            <select class="form-control" name="department" id="department" {{ $assignmentType === 'chapter' ? 'disabled' : 'required' }}>
                <option value="">-- Select Committee --</option>
                @foreach($department as $item)
                    <option value="{{ $item->name }}" {{ old('department') == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
            @error('department')<p class="text-danger small mt-1" role="alert">{{ $message }}</p>@enderror
            @include('tickets.member-assignment', ['memberType' => 'committee', 'memberColumn' => 'assigned_committee_user_id'])
        </div>
        <div class="ticket-assignment-field" data-assignment-field="chapter" {{ $assignmentType === 'committee' ? 'hidden' : '' }}>
            <label for="chapter">Chapter <span class="text-danger">*</span></label>
            <select class="form-control" name="c_id" id="chapter" {{ $assignmentType === 'committee' ? 'disabled' : 'required' }}>
                <option value="">-- Select Chapter --</option>
                @foreach($chapter as $item)
                    <option value="{{ $item->chapter_id }}" {{ old('c_id') == $item->chapter_id ? 'selected' : '' }}>{{ $item->chapter_name }}</option>
                @endforeach
            </select>
            @error('c_id')<p class="text-danger small mt-1" role="alert">{{ $message }}</p>@enderror
            @include('tickets.member-assignment', ['memberType' => 'chapter', 'memberColumn' => 'assigned_chapter_user_id'])
        </div>
    </fieldset>
</div>
<link rel="stylesheet" href="{{ asset('dist/css/ticket-assignment.css') }}">
<script src="{{ asset('dist/js/ticket-assignment.js') . '?v=' . filemtime(public_path('dist/js/ticket-assignment.js')) }}" defer></script>
