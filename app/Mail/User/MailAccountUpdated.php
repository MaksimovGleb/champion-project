<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAccountUpdated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected User $user,
                                protected string $href)
    {
    }

    public function build()
    {
        return $this
            ->subject('Профиль успешно изменен')
            ->view('mail.user.account-updated')->with([
                'user' => $this->user,
                'href' => $this->href
            ]);
    }
}
