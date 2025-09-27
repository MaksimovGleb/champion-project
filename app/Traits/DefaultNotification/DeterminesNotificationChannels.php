<?php

namespace App\Traits\DefaultNotification;

use App\Models\DefaultNotification;
use App\Models\User;

trait DeterminesNotificationChannels
{
    public function determineChannels(DefaultNotification $notificationSettings, User $notifiable): array
    {
        //$channels = ['database'];
        $channels = [];
        $notificationUser = $notificationSettings->getNotificationUser($notifiable);

        $sendEmail = $notificationSettings->edit_email
            ? $notificationUser?->send_email ?? $notificationSettings?->send_email
            : $notificationSettings?->send_email;

        if ($sendEmail) {
            $channels[] = 'mail';
        }

        return $channels;
    }
}
