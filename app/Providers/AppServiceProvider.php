<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade
        Blade::if('IsAdmin', function () {
            return auth()->user()->is_admin;
        });

        Blade::if('IsUser', function () {
            return !auth()->user()->is_admin;
        });

        // Gate
        Gate::define('IsAdmin', function ($user) {
            return $user->is_admin;
        });

        Gate::define('IsUser', function ($user) {

            return !$user->is_admin;
        });

    }
}
