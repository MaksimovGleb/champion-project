<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailUniversal extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public $subject,
                                protected string $text,
                                protected string $footer,
                                protected string $href)
    {
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view('mail.universal')->with([
                'text' => $this->text,
                'href' => $this->href,
                'footer' => $this->footer
            ]);
    }
}
