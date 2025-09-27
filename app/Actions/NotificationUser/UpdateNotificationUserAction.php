<?php

namespace App\Actions\NotificationUser;

use App\Models\DefaultNotification;
use App\Models\NotificationUser;
use App\Models\User;

/** Обновляет настройку уведомлений пользователя */
class UpdateNotificationUserAction
{
    public function execute(DefaultNotification $defaultNotification,
                            User $user, array $notificationUserData = []): NotificationUser
    {
        $notificationUser = $defaultNotification->getNotificationUser($user)
            ?? (new NotificationUser())
                ->setUser($user)
                ->setNotification($defaultNotification);

        $notificationUser
            ->setSMS($defaultNotification->edit_sms ? $notificationUserData['send_sms'] : $defaultNotification->send_sms)
            ->setEmail($defaultNotification->edit_email ? $notificationUserData['send_email'] : $defaultNotification->send_email)
            ->save();

        return $notificationUser;
    }
}
