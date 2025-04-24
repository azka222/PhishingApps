<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        {
            Relation::morphMap([
                'quiz'     => \App\Models\Quiz::class,
                'material' => \App\Models\Material::class,

            ]);

        }
        // Blade
        Blade::if('IsAdmin', function () {
            return auth()->user()->is_admin;
        });

        Blade::if('IsCompanyOwner', function ($id) {
            return auth()->user()->isCompanyOwner($id);
        });

        Blade::if('IsUser', function () {
            return ! auth()->user()->is_admin;
        });

        Blade::if('IsCompanyAdmin', function ($id) {
            return auth()->user()->companyAdmin($id);
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

        Blade::if('CanCreateLandingPage', function () {
            return auth()->user()->canCreateLandingPage();
        });

        Blade::if('CanModifyLandingPage', function () {
            return auth()->user()->canModifyLandingPage();
        });

        Blade::if('CanUpdateLandingPage', function () {
            return auth()->user()->canUpdateLandingPage();
        });

        Blade::if('CanDeleteLandingPage', function () {
            return auth()->user()->canDeleteLandingPage();
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

        Blade::if('HaveAccessApproval', function () {
            return auth()->user()->haveAccessApproval();
        });

        Blade::if('CanAccessEmployeeDashboard', function () {
            return auth()->user()->employee;
        });

        Blade::if('CanAccessCourse', function () {
            return auth()->user()->employee;
        });

        // Gate
        Gate::define('IsAdmin', function ($user) {
            return $user->is_admin;
        });
        Gate::define('IsCompanyAdmin', function ($user, $id) {
            return $user->companyAdmin($id);
        });

        Gate::define('CanAccessDashboard', function ($user) {
            return $user->canAccessDashboard();
        });

        Gate::define('CanCreateTarget', function ($user) {
            return $user->canCreateTarget();
        });

        Gate::define('CanUpdateTarget', function ($user) {
            return $user->canUpdateTarget();
        });

        Gate::define('CanDeleteTarget', function ($user) {
            return $user->canDeleteTarget();
        });

        Gate::define('CanReadTarget', function ($user) {
            return $user->haveAccess('Target', 'read');
        });

        Gate::define('CanReadGroup', function ($user) {
            return $user->haveAccess('Group', 'read');
        });

        Gate::define('CanCreateGroup', function ($user) {
            return $user->canCreateGroup();
        });

        Gate::define('CanUpdateGroup', function ($user) {
            return $user->canUpdateGroup();
        });

        Gate::define('CanDeleteGroup', function ($user) {
            return $user->canDeleteGroup();
        });

        Gate::define('CanCreateSendingProfile', function ($user) {
            return $user->canCreateSendingProfile();
        });

        Gate::define('CanUpdateSendingProfile', function ($user) {
            return $user->canUpdateSendingProfile();
        });

        Gate::define('CanDeleteSendingProfile', function ($user) {
            return $user->canDeleteSendingProfile();
        });

        Gate::define('CanReadSendingProfile', function ($user) {
            return $user->haveAccess('Sending Profile', 'read');
        });

        Gate::define('CanCreateLandingPage', function ($user) {
            return $user->canCreateLandingPage();
        });

        Gate::define('CanReadLandingPage', function ($user) {
            return $user->haveAccess('Landing Page', 'read');
        });

        Gate::define('CanUpdateLandingPage', function ($user) {
            return $user->canUpdateLandingPage();
        });

        Gate::define('CanDeleteLandingPage', function ($user) {
            return $user->canDeleteLandingPage();
        });

        Gate::define('CanReadEmailTemplate', function ($user) {
            return $user->haveAccess('Email Template', 'read');
        });

        Gate::define('CanCreateEmailTemplate', function ($user) {
            return $user->canCreateEmailTemplate();
        });

        Gate::define('CanUpdateEmailTemplate', function ($user) {
            return $user->canUpdateEmailTemplate();
        });

        Gate::define('CanDeleteEmailTemplate', function ($user) {
            return $user->canDeleteEmailTemplate();
        });

        Gate::define('CanCreateCampaign', function ($user) {
            return $user->canCreateCampaign();
        });

        Gate::define('CanDeleteCampaign', function ($user) {
            return $user->canDeleteCampaign();
        });

        Gate::define('CanReadCampaign', function ($user) {
            return $user->haveAccess('Campaign', 'read');
        });

        Gate::define('isCompanyOwner', function ($user, $id) {
            return $user->isCompanyOwner($id);
        });

        Gate::define('HaveAccessApproval', function ($user) {
            return $user->haveAccessApproval();
        });

        Gate::define('CanStartCourse', function($user, $id){
            return $user->canStartCourse($id);
        });

    }
}
