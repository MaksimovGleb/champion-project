<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Services\Interfaces\ShortUrl\ShortUrlServiceInterface;
use App\Services\ShortUrl\ShortUrlByBase62Service;
use App\Services\SiteSettings\PermissionSettings;
use App\Services\SiteSettings\RoleSettings;
use App\Services\SiteSettings\UserJuniors;
use App\Services\SiteSettings\UserMiddles;
use App\Services\SiteSettings\UserSeniors;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(ShortUrlServiceInterface::class, function ($app) {
            return new ShortUrlByBase62Service();
        });

        $this->app->bind(ShortUrlServiceInterface::class, function ($app) {
            return new ShortUrlByBase62Service();
        });

        $this->app->singleton(RoleSettings::class, function () {
            return new RoleSettings();
        });

        $this->app->singleton(PermissionSettings::class, function () {
            return new PermissionSettings();
        });

        $this->app->singleton(UserJuniors::class, function () {
            return new UserJuniors();
        });

        $this->app->singleton(UserMiddles::class, function () {
            return new UserMiddles();
        });

        $this->app->singleton(UserSeniors::class, function () {
            return new UserSeniors();
        });

    }

    public function boot()
    {
        User::observe(UserObserver::class);
        // Enable pagination
        if (! Collection::hasMacro('paginate')) {
            Collection::macro(
                'paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage)->values()->all(),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))
                        ->withPath('');
                }
            );
        }
    }
}
