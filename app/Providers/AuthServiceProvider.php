<?php

namespace App\Providers;

use App\Models\DefaultNotification;
use App\Models\NotificationUser;
use App\Policies\NotificationPolicy;
use App\Policies\NotificationSettingsPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //Auth::class => UserPolicy::class,
        DatabaseNotification::class => NotificationPolicy::class,
        NotificationUser::class => NotificationSettingsPolicy::class,
        DefaultNotification::class => NotificationSettingsPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('attach-show', function ($user, $attach) {
            if ($user->isAdmin(true) || $user->isUrist(true)) {
                return Response::allow();
            }

            return Response::deny();
        });

        // Implicitly grant "Super-Admin" role all permission checks using can()
//        Gate::before(function ($user, $ability) {
//            if ($user->hasRole('Super-Admin')) {
//                return true;
//            }
//        });
    }
}
