<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportMailTemplate extends Model
{
    use SoftDeletes;
    protected $table = 'mail_templates';
    protected $guarded = ['id'];
    public const EVENTS = ['support_ticket_created' => 'Ticket Created', 'support_ticket_updated' => 'Ticket Updated'];

    public static function audienceBody($body, $audience, $assignmentType = null)
    {
        $targetType = in_array($assignmentType, ['committee', 'chapter', 'member']) ? $assignmentType : 'member';
        $sections = [
            'creator' => $audience === 'creator', 'target' => $audience === 'target',
            'committee' => $audience === 'target' && $targetType === 'committee',
            'chapter' => $audience === 'target' && $targetType === 'chapter',
            'member' => $audience === 'target' && $targetType === 'member',
        ];
        foreach ($sections as $section => $show) {
            $body = preg_replace_callback('~{{#'.$section.'}}(.*?){{/'.$section.'}}~s', function ($match) use ($show) {
                return $show ? $match[1] : '';
            }, (string) $body);
        }
        return $body;
    }
}
