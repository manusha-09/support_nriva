@auth
@if(\App\Services\TicketSettings::memberAssignmentEnabled())
<div data-member-assignment hidden class="mt-3">
    <label class="d-flex align-items-center" for="assign-{{ $memberType }}-member">
        <input type="checkbox" id="assign-{{ $memberType }}-member" name="assign_{{ $memberType }}_member" value="1" class="mr-2" {{ old('assign_'.$memberType.'_member') ? 'checked' : '' }}>
        I want to assign it to a particular member
    </label>
    <div data-member-picker hidden>
        <label for="{{ $memberColumn }}">{{ ucfirst($memberType) }} member and role</label>
        <select id="{{ $memberColumn }}" name="{{ $memberColumn }}" class="form-control" data-old-value="{{ old($memberColumn) }}" disabled>
            <option value="">-- Select Member --</option>
        </select>
        <p class="small text-muted mt-1" data-member-message aria-live="polite">Active members for the default year.</p>
    </div>
    @error($memberColumn)<p class="text-danger small" role="alert">{{ $message }}</p>@enderror
</div>
@endif
@endauth
