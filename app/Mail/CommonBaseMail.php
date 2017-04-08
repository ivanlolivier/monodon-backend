<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommonBaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title = '';
    public $introLines = [];
    public $outroLines = [];

    public $buttons = null;
    public $level;
}
