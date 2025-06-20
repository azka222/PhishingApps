<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GophishController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
        $user = User::find($id);
        if (! $user) {
            abort(404, 'User not found');
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect()->route('login')->with('message', 'Email verified successfully.');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/loginEmployeeAccount', [AuthenticateController::class, 'loginEmployeeAccount'])->name('loginEmployeeAccount');
    Route::get('/login', [ViewController::class, 'loginView'])->name('loginView');
    Route::get('/register', [ViewController::class, 'registerView'])->name('registerView');
    Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
    Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
    Route::get('/getCompanies', [CompanyController::class, 'getCompanies'])->name('getCompanies');
    Route::post('/checkCompanies', [CompanyController::class, 'checkCompany'])->name('checkCompany');
    Route::post('/createCompany', [CompanyController::class, 'createCompany'])->name('createCompany');
    Route::get('/forgot-password', [ViewController::class, 'forgotPasswordView'])->name('forgotPasswordView');
    Route::post('/forgot-password', [AuthenticateController::class, 'forgotPassword'])->name('forgotPassword');
    Route::get('/reset-password', [ViewController::class, 'resetPasswordView'])->name('resetPasswordView');
    Route::post('/checkAccountEmployee', [AuthenticateController::class, 'checkAccountEmployee'])->name('checkAccountEmployee');
});
Route::post('/reset-password', [AuthenticateController::class, 'resetPasswordSubmit'])->name('resetPassword');

// ==================================== if user login success ====================================
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::middleware(['auth', 'employee'])->prefix('course')->group(function () {
        // Route::get('/dashboard', [ViewController::class, 'employeeDashboardView'])->name('employeeDashboardView');
        Route::get('/employeeLogout', [AuthenticateController::class, 'logout'])->name('employeeLogout');
        Route::get('/lists', [ViewController::class, 'courseListsView'])->name('courseLists');
        Route::get('/getCourse', [CourseController::class, 'getCourseEmployee'])->name('getCourseEmployee');
        Route::get('/start-course/{id}', [ViewController::class, 'startCourseView'])->name('startCourseView');
        Route::get('/getCourseDetails', [CourseController::class, 'getCourseDetails'])->name('getCourseDetailsEmployee');
        Route::post('/submitCourse', [CourseController::class, 'submitCourse'])->name('submitQuizEmployee');

    });
    route::group(['middleware' => ['auth', 'notEmployee']], function () {
        Route::get('/dashboard', [ViewController::class, 'dashboardView'])->name('dashboard1');
        Route::get('/', [ViewController::class, 'dashboardView'])->name('dashboard');
        Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');
        Route::group(['prefix' => 'user-setting'], function () {
            Route::get('/', [ViewController::class, 'userSettingView'])->name('userSettingView');
            Route::get('/getProfileDetails', [UserController::class, 'getProfileDetails'])->name('getProfileDetails');
            Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');
            Route::post('/sendOtp', [AuthenticateController::class, 'sendOtp'])->name('sendOtp');
            Route::post('/verifyOtp', [AuthenticateController::class, 'verifyOtp'])->name('verifyOtp');
            Route::post('/resendOtp', [AuthenticateController::class, 'resendOtp'])->name('resendOtp');
            Route::post('/changePassword', [AuthenticateController::class, 'changePassword'])->name('changePassword');
            Route::get('/getCompanyDetails', [CompanyController::class, 'getCompanyDetails'])->name('getCompanyDetails');
            Route::post('/updateCompany', [CompanyController::class, 'updateCompany'])->name('updateCompany');
            Route::get('/getCompanyUsers', [CompanyController::class, 'getCompanyUsers'])->name('getCompanyUsers');
            Route::get('/getRoles', [CompanyController::class, 'getRoles'])->name('getRoles');
            Route::get('/getRoleDetails', [CompanyController::class, 'getRoleDetails'])->name('getRoleDetails');
            Route::post('/updateRole', [CompanyController::class, 'updateRole'])->name('updateRole');
            Route::post('/createRole', [CompanyController::class, 'createRole'])->name('createRole');
            Route::post('/deleteRole', [CompanyController::class, 'deleteRole'])->name('deleteRole');
            Route::post('/updateUserCompany', [CompanyController::class, 'updateUserCompany'])->name('updateUserCompany');

        });

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/getDataDashboard', [GophishController::class, 'getDashboardData'])->name('getDashboardData');
            Route::get('/getAllEmployeeRisks', [GophishController::class, 'getAllEmployeeRisks'])->name('getAllEmployeeRisks');
        });

        Route::group(['prefix' => 'target'], function () {
            Route::get('/', [ViewController::class, 'targetView'])->name('targetView');
            Route::get('/getTargetResources', [TargetController::class, 'getTargetResources'])->name('getTargetResources');
            Route::get('/getTargets', [TargetController::class, 'getTargets'])->name('getTargets');
            Route::post('/createTarget', [TargetController::class, 'createTarget'])->name('createTarget');
            Route::post('/updateTarget', [TargetController::class, 'updateTarget'])->name('updateTarget');
            Route::post('/deleteTarget', [TargetController::class, 'deleteTarget'])->name('deleteTarget');
            Route::post('/previewImportTarget', [TargetController::class, 'previewImportTarget'])->name('previewImportTarget');
            Route::post('/importTarget', [TargetController::class, 'importTarget'])->name('importTarget');
            Route::get('/downloadTemplateTarget', [TargetController::class, 'downloadTemplateTarget'])->name('downloadTemplateTarget');
        });

        Route::group(['prefix' => 'groups'], function () {
            Route::get('/', [ViewController::class, 'groupView'])->name('groupView');
            Route::get('/getGroups', [GroupController::class, 'getGroups'])->name('getGroups');
            Route::get('/getGroupResources', [GroupController::class, 'getGroupResources'])->name('getGroupResources');
            Route::post('/createGroup', [GroupController::class, 'createGroup'])->name('createGroup');
            Route::post('/updateGroup', [GroupController::class, 'updateGroup'])->name('updateGroup');
            Route::post('/deleteGroup', [GroupController::class, 'deleteGroup'])->name('deleteGroup');

        });

        Route::group(['prefix' => 'landing-page'], function () {
            Route::get('/', [ViewController::class, 'landingPageView'])->name('landingPageView');
            Route::get('/getLandingPage', [GophishController::class, 'getLandingPage'])->name('getLandingPage');
            Route::get('/landingPagePreview/{id}', [GophishController::class, 'landingPagePreview'])->name('landingPagePreview');
            Route::get('/preview', [ViewController::class, 'landingPagePreview'])->name('content.landingPagePreview');
            Route::post('/importSiteUrl', [GophishController::class, 'fetchWebsiteUrl'])->name('fetchWebsiteUrl');
            Route::post('/createLandingPage', [GophishController::class, 'createLandingPage'])->name('createLandingPage');
            Route::post('/testLandingPage', [GophishController::class, 'testLandingPage'])->name('testLandingPage');
            Route::get('/preview-page/{id}', [GophishController::class, 'showPreviewPage'])->name('showPagePreview');
            Route::post('/updateLandingPage', [GophishController::class, 'updateLandingPage'])->name('updateLandingPage');
            Route::post('/deleteLandingPage', [GophishController::class, 'deleteLandingPage'])->name('deleteLandingPage');
        });

        Route::group(['prefix' => 'email-templates'], function () {
            Route::get('/', [ViewController::class, 'emailTemplatesView'])->name('emailTemplatesView');
            Route::get('/getEmailTemplate', [GophishController::class, 'getEmailTemplate'])->name('getEmailTemplate');
            Route::post('/createEmailTemplate', [GophishController::class, 'createEmailTemplate'])->name('createEmailTemplate');
            Route::post('/updateEmailTemplate', [GophishController::class, 'updateEmailTemplate'])->name('updateEmailTemplate');
            Route::post('/deleteEmailTemplate', [GophishController::class, 'deleteEmailTemplate'])->name('deleteEmailTemplate');
            Route::post('/activateEmailTemplate', [GophishController::class, 'activateEmailTemplate'])->name('activateEmailTemplate');
            Route::get('/downloadEmailAttachment', [GophishController::class, 'downloadEmailAttachment'])->name('downloadEmailAttachment');
        });

        Route::group(['prefix' => 'sending-profile'], function () {
            Route::get('/', [ViewController::class, 'sendingProfileView'])->name('sendingProfileView');
            Route::get('/getSendingProfile', [GophishController::class, 'getSendingProfile'])->name('getSendingProfile');
            Route::post('/createSendingProfile', [GophishController::class, 'createSendingProfile'])->name('createSendingProfile');
            Route::post('/updateSendingProfile', [GophishController::class, 'updateSendingProfile'])->name('updateSendingProfile');
            Route::post('/deleteSendingProfile', [GophishController::class, 'deleteSendingProfile'])->name('deleteSendingProfile');
            Route::post('/activateSendingProfile', [GophishController::class, 'activateSendingProfile'])->name('activateSendingProfile');
            Route::post('/testSendingProfile', [GophishController::class, 'testSendingProfile'])->name('testSendingProfile');
        });

        Route::group(['prefix' => 'campaigns'], function () {
            Route::get('/', [ViewController::class, 'campaignView'])->name('campaignView');
            Route::get('/campaignDetails/{id}', [ViewController::class, 'campaignDetailsView'])->name('campaignDetailsView');
            Route::get('/getCampaignResources', [GophishController::class, 'getCampaignResources'])->name('getCampaignResources');
            Route::get('/getCampaigns', [GophishController::class, 'getCampaigns'])->name('getCampaigns');
            Route::post('/testConnection', [GophishController::class, 'testConnection'])->name('testConnection');
            Route::post('/createCampaign', [GophishController::class, 'createCampaign'])->name('createCampaign');
            Route::post('/deleteCampaign', [GophishController::class, 'deleteCampaign'])->name('deleteCampaign');
            Route::get('/getCampaignData', [GophishController::class, 'getCampaignData'])->name('getCampaignData');
            Route::post('/sendNewApproval', [ApprovalController::class, 'sendNewApproval'])->name('sendNewApproval');
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [ViewController::class, 'adminUserView'])->name('adminUserView');
                Route::get('/getAllUser', [AdminController::class, 'getAllUser'])->name('getAllUser');
                Route::post('/editUser', [AdminController::class, 'editUser'])->name('editUser');
                Route::get('/getUserbyCompany/{id}', [AdminController::class, 'getUsersByCompanyId'])->name('getUsersByCompanyId');
                Route::get('/course', [ViewController::class, 'AdminCourseView'])->name('adminCourseView');
                Route::get('/create-course', [ViewController::class, 'createCourseView'])->name('createCourseView');
                Route::post('/createCourse', [CourseController::class, 'createCourse'])->name('createCourse');
                Route::get('/getCourse', [CourseController::class, 'getCourse'])->name('getCourse');
                Route::post('/deleteCourse', [CourseController::class, 'deleteCourse'])->name('deleteCourse');
                Route::get('/editCourse/{id}', [ViewController::class, 'editCourseView'])->name('editCourseView');
                Route::get('/getCourseDetails', [CourseController::class, 'getCourseDetails'])->name('getCourseDetails');
                Route::post('/updateCourse', [CourseController::class, 'updateCourse'])->name('updateCourse');

            });
            Route::group(['prefix' => 'company'], function () {
                Route::get('/', [ViewController::class, 'adminCompanyView'])->name('adminCompanyView');
                Route::get('/getAllCompany', [AdminController::class, 'getAllCompany'])->name('getAllCompany');
                Route::post('/editCompany', [AdminController::class, 'editCompany'])->name('editCompany');
                Route::post('/deleteUser', [AdminController::class, 'deleteUser'])->name('deleteUser');
                Route::post('/deleteCompany', [AdminController::class, 'deleteCompany'])->name('deleteCompany');
                Route::get('/getCompanyUsers', [ViewController::class, 'adminCompanyUserByCompanyIdView'])->name('adminCompanyUserByCompanyIdView');
            });
        });

        Route::group(['prefix' => 'approval'], function () {
            Route::get('/', [ViewController::class, 'approvalView'])->name('approvalView');
            Route::get('/getApproval', [ApprovalController::class, 'getAllApproval'])->name('getApproval');
            Route::post('/actionApproval', [ApprovalController::class, 'submitCampaignApproval'])->name('actionApproval');
            Route::get('/{campaignId}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
            Route::get('/{campaignId}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');

        });
    });

});
