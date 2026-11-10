<?php

namespace App\Http\Controllers;

use App\Models\SupportMailTemplate;
use Illuminate\Http\Request;

class SupportMailTemplateController extends Controller
{
    public function index()
    {
        $templates = SupportMailTemplate::whereIn('type', array_keys(SupportMailTemplate::EVENTS))->get();
        return view('tickets.mail-templates', compact('templates'));
    }

    public function update(Request $request, $id)
    {
        $template = SupportMailTemplate::whereIn('type', array_keys(SupportMailTemplate::EVENTS))->findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:191', 'subject' => 'required|string|max:191',
            'status' => 'required|in:0,1', 'from_email' => 'nullable|email|max:191',
            'to_email' => 'nullable|string|max:191', 'cc_emails' => 'required|string|max:191',
            'creator_template' => 'required|string|max:50000',
            'target_template' => 'nullable|string|max:50000',
            'committee_template' => 'required_without:target_template|string|max:50000',
            'chapter_template' => 'required_without:target_template|string|max:50000',
            'member_template' => 'required_without:target_template|string|max:50000',
        ]);
        foreach (['to_email', 'cc_emails'] as $field) {
            foreach (array_filter(array_map('trim', explode(',', $data[$field] ?? ''))) as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw \Illuminate\Validation\ValidationException::withMessages([$field => 'Enter valid email addresses separated by commas.']);
                }
            }
        }
        // Retain compatibility with a previously opened two-body form.
        $targetBody = $data['target_template'] ?? '';
        if (isset($data['committee_template'], $data['chapter_template'], $data['member_template'])) {
            $targetBody = '';
            foreach (['committee', 'chapter', 'member'] as $type) {
                $targetBody .= '{{#'.$type.'}}'.$data[$type.'_template'].'{{/'.$type.'}}';
            }
        }
        $data['template'] = '{{#creator}}'.$data['creator_template'].'{{/creator}}{{#target}}'.$targetBody.'{{/target}}';
        unset($data['creator_template'], $data['target_template'], $data['committee_template'], $data['chapter_template'], $data['member_template']);
        $data['updated_by'] = (string) auth()->id();
        $template->update($data);
        return redirect()->route('mail-templates.index')->with('success', 'Mail template saved.');
    }
}
