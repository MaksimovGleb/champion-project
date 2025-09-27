<?php

namespace App\Listeners\User;

use App\Events\User\EventPasswordChanged;
use App\Notifications\User\NotificationPasswordChanged;
use Illuminate\Support\Facades\Notification;

/** Изменен пароль */
class ListenerPasswordChanged
{
    public function __construct()
    {
        //
    }

    public function handle(EventPasswordChanged $event)
    {
        $href = match (true) {
            default => route('user.login'),
        };

        Notification::send($event->user,
            new NotificationPasswordChanged($event->user, $event->password, $href));
    }
}
