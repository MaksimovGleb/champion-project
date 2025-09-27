<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailRecoveryPass extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected User $user,
                                protected string $href)
    {
    }

    public function build()
    {
        return $this->subject('Смена пароля')
            ->view('mail.user.recovery-pass')->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'href' => $this->href,
            ]);
    }
}
