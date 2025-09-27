<?php

namespace App\Listeners\User;

use App\Events\User\EventAccountUpdated;
use App\Notifications\User\NotificationAccountUpdated;
use Illuminate\Support\Facades\Notification;

/** Аккаунт обновлен */
class ListenerAccountUpdated
{
    public function __construct()
    {
        //
    }

    public function handle(EventAccountUpdated $event)
    {
        $href = match (true) {
            default => route('user.login'),
        };

        Notification::send($event->user,
            new NotificationAccountUpdated($event->user, $href));
    }

}
