<?php

namespace App\Notifications;

use App\Models\DefaultNotification;;
use App\Traits\DefaultNotification\DeterminesNotificationChannels;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/** Общее для всех уведомлений */
abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable, DeterminesNotificationChannels;

    protected DefaultNotification $notificationSettings;

    public function __construct()
    {
        $this->notificationSettings = DefaultNotification::where('notification_type', static::class)->first();
    }

    public function via($notifiable)
    {
        return $this->determineChannels($this->notificationSettings, $notifiable);
    }
}
