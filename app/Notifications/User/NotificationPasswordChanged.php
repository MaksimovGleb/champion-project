<?php

namespace App\Notifications\User;

use App\Mail\User\MailPasswordChanged;
use App\Models\User;
use App\Notifications\BaseNotification;

/** Изменен пароль */
class NotificationPasswordChanged extends BaseNotification
{
    public function __construct(protected User $user, protected string $password, private readonly string $href)
    {
        parent::__construct();
    }

    public function toMail($notifiable)
    {
        if ($notifiable?->email)
            return (new MailPasswordChanged($this->user, $this->href, $this->password))
                ->to($notifiable->email);

        return true;
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
        ];
    }

    public function broadcastType()
    {
        return 'broadcast.user';
    }
}
