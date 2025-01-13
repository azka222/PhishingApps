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
        Blade::if('IsCompanyOwner', function () {
            return auth()->user()->companyOwner();
        });
        Blade::if('CanAccess', function ($module, $ability) {
            return auth()->user()->haveAccess($module, $ability);
        });

        Blade::if('CanAccessDashboard', function () {
            return auth()->user()->canAccessDashboard();
        });

        Blade::if('CanAccessTargetGroup', function () {
            return auth()->user()->canAccessTargetGroup();
        });

        Blade::if('CanAccessAttribute', function () {
            return auth()->user()->canAccessAttribute();
        });

        Blade::if('CanCreateTarget', function () {
            return auth()->user()->canCreateTarget();
        });

        Blade::if('CanUpdateTarget', function () {
            return auth()->user()->canUpdateTarget();
        });
        Blade::if('CanDeleteTarget', function () {
            return auth()->user()->canDeleteTarget();
        });
        Blade::if('CanModifyTarget', function () {
            return auth()->user()->canModifyTarget();
        });

        Blade::if('CanCreateGroup', function () {
            return auth()->user()->canCreateGroup();
        });

        Blade::if('CanModifyGroup', function () {
            return auth()->user()->canModifyGroup();
        });

        Blade::if('CanUpdateGroup', function () {
            return auth()->user()->canUpdateGroup();
        });

        Blade::if('CanDeleteGroup', function () {
            return auth()->user()->canDeleteGroup();
        });

        Blade::if('CanCreateSendingProfile', function () {
            return auth()->user()->canCreateSendingProfile();
        });

        Blade::if('CanModifySendingProfile', function () {
            return auth()->user()->canModifySendingProfile();
        });

        Blade::if('CanUpdateSendingProfile', function () {
            return auth()->user()->canUpdateSendingProfile();
        });

        Blade::if('CanDeleteSendingProfile', function () {
            return auth()->user()->canDeleteSendingProfile();
        });

        Blade::if('CanCreateEmailTemplate', function () {
            return auth()->user()->canCreateEmailTemplate();
        });
        Blade::if('CanUpdateEmailTemplate', function () {
            return auth()->user()->canUpdateEmailTemplate();
        });
        Blade::if('CanModifyEmailTemplate', function () {
            return auth()->user()->canModifyEmailTemplate();
        });
        Blade::if('CanDeleteEmailTemplate', function () {
            return auth()->user()->canDeleteEmailTemplate();
        });

        Blade::if('CanCreateCampaign', function () {
            return auth()->user()->canCreateCampaign();
        });

        Blade::if('CanDeleteCampaign', function () {
            return auth()->user()->canDeleteCampaign();
        });

        // Gate
        Gate::define('IsAdmin', function ($user) {
            return $user->is_admin;
        });
        Gate::define('IsCompanyOwner', function ($user) {
            return $user->companyOwner();
        });

        Gate::define('CanAccessDashboard', function ($user) {
            return $user->canAccessDashboard();
        });

    }
}
