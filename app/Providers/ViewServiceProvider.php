<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Company;

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
        view()->composer('contents.page.dashboard', function ($view){
            $view->with('companies', Company::all());
        });
        view()->composer('layouts.header', function ($view) {
            $user = auth()->user();
            $name = $user->first_name . ' ' . $user->last_name;
            $view->with('name', $name);
        });

        view()->composer('layouts.employee-header', function ($view) {
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
