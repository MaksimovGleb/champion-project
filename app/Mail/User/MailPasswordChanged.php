<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailPasswordChanged extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected User $user,
                                protected string $href,
                                protected $pass = false)
    {
    }

    public function build()
    {
        return $this->subject('Ваш пароль успешно изменен')
            ->view('mail.user.new-pass')->with([
                'user' => $this->user,
                'password' => $this->pass,
                'href' => $this->href
            ]);
    }
}
