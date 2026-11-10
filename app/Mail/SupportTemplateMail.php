<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SupportTemplateMail extends Mailable
{
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->html($this->content);
    }
}

