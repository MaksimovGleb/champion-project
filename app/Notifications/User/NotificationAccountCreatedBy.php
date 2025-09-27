<?php

namespace App\Notifications\User;

use App\Mail\User\MailAccountCreated;
use App\Models\User;
use App\Notifications\BaseNotification;

/** Создан аккаунт. Выслать пароль в mail */
class NotificationAccountCreatedBy extends BaseNotification
{
    public function __construct(protected User $user, protected string $password, private readonly string $href)
    {
        parent::__construct();
    }

    public function toMail($notifiable)
    {
        if ($notifiable?->email)
            return (new MailAccountCreated($this->user, $this->password, $this->href))
                ->to($notifiable->email);

        return true;
    }

    public function toArray($notifiable)
    {
        return [];
    }

    public function broadcastType()
    {
        return 'broadcast.user';
    }
}
