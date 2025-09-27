<?php

namespace App\Notifications\User;

use App\Mail\User\MailRecoveryPass;
use App\Models\User;
use App\Notifications\BaseNotification;

/** Запрошено восстановление пароля */
class NotificationRecoveryPass extends BaseNotification
{
    public function __construct(protected User $user, private readonly string $href)
    {
        parent::__construct();
    }

    public function toMail($notifiable)
    {
        if ($notifiable?->email)
            return (new MailRecoveryPass($this->user,$this->href))
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
