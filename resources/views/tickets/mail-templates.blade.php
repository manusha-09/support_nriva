@include('navbar')
@include('sidemenu')
<div class="content-wrapper">
<section class="content-header"><h1 class="h4">Mail Templates</h1></section>
<section class="content">
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<p>These templates are stored in the shared NRIVA mail templates table. Changes here also appear in NRIVA admin.</p>
<p>Ticket Created and Ticket Updated send separate emails to the creator and each assigned target, with different message text for each audience. Without a selected member, the target is the committee or chapter email saved in NRIVA. With a selected member, the target is that member instead. Both assignments notify each selected target. Comments and status changes notify both sides, regardless of who made the change. CC applies to every email.</p>
@foreach($templates as $template)
<div class="card mb-4">
<div class="card-header"><h2 class="card-title">{{ \App\Models\SupportMailTemplate::EVENTS[$template->type] }}</h2></div>
<form method="POST" action="{{ route('mail-templates.update', $template->id) }}">
@csrf @method('PUT')
<div class="card-body">
<div class="row">
@foreach(['name' => 'Title', 'subject' => 'Subject', 'from_email' => 'Mail From', 'to_email' => 'Additional Mail To', 'cc_emails' => 'CC Emails (comma separated)'] as $field => $label)
<div class="col-md-6 form-group"><label for="{{ $field }}-{{ $template->id }}">{{ $label }}</label>
<input id="{{ $field }}-{{ $template->id }}" class="form-control" name="{{ $field }}" value="{{ (string) old('_template_id') === (string) $template->id ? old($field) : $template->$field }}" maxlength="191" {{ in_array($field, ['name','subject','cc_emails']) ? 'required' : '' }}></div>
@endforeach
<div class="col-md-6 form-group"><label for="status-{{ $template->id }}">Status</label><select id="status-{{ $template->id }}" name="status" class="form-control">@foreach([1 => 'Active', 0 => 'Inactive'] as $value => $label)<option value="{{ $value }}" {{ (string) ((string) old('_template_id') === (string) $template->id ? old('status') : $template->status) === (string) $value ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
</div>
<p class="text-muted">Leave Mail From blank to use the configured sender. Mail To adds recipients to the automatic ticket recipients. Keep technology@nriva.org in CC to meet the client requirement.</p>
<input type="hidden" name="_template_id" value="{{ $template->id }}">
@foreach(['creator' => 'Email text for ticket creator', 'committee' => 'Email text for committee group', 'chapter' => 'Email text for chapter group', 'member' => 'Email text for selected member'] as $audience => $audienceLabel)
@php
    $audienceBody = \App\Models\SupportMailTemplate::audienceBody($template->template, $audience === 'creator' ? 'creator' : 'target', $audience);
@endphp
<label class="mt-3" for="{{ $audience }}-body-{{ $template->id }}">{{ $audienceLabel }}</label>
<textarea id="{{ $audience }}-body-{{ $template->id }}" class="form-control mail-body" name="{{ $audience }}_template" rows="10" required>{{ (string) old('_template_id') === (string) $template->id ? old($audience.'_template') : $audienceBody }}</textarea>
@endforeach
<p class="mt-2">Use these placeholders in subject or template:</p>
<code>@{{ticket_id}} @{{subject}} @{{creator_name}} @{{creator_email}} @{{committee}} @{{chapter}} @{{status}} @{{priority}} @{{description}} @{{actor_name}} @{{changes}} @{{ticket_url}} @{{recipient_name}} @{{assignment_type}} @{{assignment_name}}</code>
<p class="mt-2">Edit the creator, committee, chapter and member messages independently. Both sends the committee and chapter their respective messages. Selecting a member uses the member message instead of that group's message. Use changes for comments and status changes.</p>
</div><div class="card-footer"><button class="btn btn-primary" type="submit">Save Template</button></div>
</form></div>
@endforeach
</section></div>
@include('categories.script')
<script>
jQuery(function ($) {
    if ($.fn.summernote) {
        $('textarea.mail-body').summernote({height: 280, toolbar: [['style', ['bold', 'italic', 'underline']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link', 'table']], ['view', ['codeview']]]});
    }
});
</script>
</div></body></html>

