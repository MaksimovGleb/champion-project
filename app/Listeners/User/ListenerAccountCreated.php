<?php

namespace App\Listeners\User;

use App\Events\User\EventAccountCreated;
use App\Notifications\User\NotificationAccountCreated;
use HtmlHelper;
use Illuminate\Support\Facades\Notification;

/** Создан аккаунт. Выслать пароль в смс и mail */
class ListenerAccountCreated
{
    public function __construct()
    {
        //
    }

    public function handle(EventAccountCreated $event)
    {
        $href = match (true) {
            default => HtmlHelper::getUrl() . 'auth',
        };

        Notification::send($event->user,
            new NotificationAccountCreated($event->user, $event->password, $href));
    }
}
