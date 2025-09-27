<?php

namespace App\Listeners\User;

use App\Events\User\EventAccountCreatedBy;
use App\Notifications\User\NotificationAccountCreatedBy;
use HtmlHelper;
use Illuminate\Support\Facades\Notification;

/** Создан аккаунт. Выслать пароль в смс и mail */
class ListenerAccountCreatedBy
{
    public function __construct()
    {
        //
    }

    public function handle(EventAccountCreatedBy $event)
    {
        $href = HtmlHelper::getUrl() . 'auth';
        Notification::send($event->user,
            new NotificationAccountCreatedBy($event->user, $event->password, $href));
    }

}
