<?php

namespace App\Providers;

use App\Events\User\EventAccountCreated;
use App\Events\User\EventAccountCreatedBy;
use App\Events\User\EventAccountDeleted;
use App\Events\User\EventAccountUpdated;
use App\Events\User\EventPasswordChanged;
use App\Listeners\User\ListenerAccountCreated;
use App\Listeners\User\ListenerAccountCreatedBy;
use App\Listeners\User\ListenerAccountUpdated;
use App\Listeners\User\ListenerPasswordChanged;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        /** Изменен пароль */
        EventPasswordChanged::class => [
            ListenerPasswordChanged::class,
        ],

        /** Зарегистрирован пользователь другим пользователем */
        EventAccountCreatedBy::class => [
            ListenerAccountCreatedBy::class,
        ],

        /** Зарегистрирован пользователь */
        EventAccountCreated::class => [
            ListenerAccountCreated::class,
        ],

        /** Данные о пользователе обновлены */
        EventAccountUpdated::class => [
            ListenerAccountUpdated::class,
        ],

        /** Пользователь удален */
        EventAccountDeleted::class => [
        ],
    ];

    public function boot()
    {
        //
    }
}
