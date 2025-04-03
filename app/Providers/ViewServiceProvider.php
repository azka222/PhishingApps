<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.header', function ($view) {
            $user = auth()->user();
            $name = $user->first_name . ' ' . $user->last_name;
            $view->with('name', $name);
        });

        view()->composer('contents.page.user-setting', function($view){
            $user = auth()->user();
            $name = $user->first_name . ' ' . $user->last_name;
            $view->with('name', $name);
        });
    }
}
