<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAccountCreated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected User $user,
                                protected  string $password,
                                protected string $href)
    {
    }

    public function build()
    {
        return $this
            ->subject('Аккаунт успешно создан')
            ->view('mail.user.account-created')->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->password,
                'id' => $this->user->id,
                'token' => $this->user->remember_token,
                'href' => $this->href
            ]);
    }
}
