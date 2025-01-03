<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CompanyController;
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
    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        $user = User::find($request->route('id'));
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return redirect()->route('login');
    })->middleware(['signed'])->name('verification.verify');
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
});
Route::post('/reset-password', [AuthenticateController::class, 'resetPasswordSubmit'])->name('resetPassword');

// ==================================== if user login success ====================================
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('contents.dashboard');
    })->name('dashboard');
    Route::get('/', function () {
        return view('contents.dashboard');
    });
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

    });

    Route::group(['prefix' => 'email-templates'], function () {
        Route::get('/', [ViewController::class, 'emailTemplatesView'])->name('emailTemplatesView');
        Route::get('/getEmailTemplate', [GophishController::class, 'getEmailTemplate'])->name('getEmailTemplate');
        Route::post('/createEmailTemplate', [GophishController::class, 'createEmailTemplate'])->name('createEmailTemplate');
        Route::post('/updateEmailTemplate', [GophishController::class, 'updateEmailTemplate'])->name('updateEmailTemplate');
        Route::post('/deleteEmailTemplate', [GophishController::class, 'deleteEmailTemplate'])->name('deleteEmailTemplate');
        Route::post('/activateEmailTemplate', [GophishController::class, 'activateEmailTemplate'])->name('activateEmailTemplate');
    });

    Route::group(['prefix' => 'sending-profile'], function () {
        Route::get('/', [ViewController::class, 'sendingProfileView'])->name('sendingProfileView');
        Route::get('/getSendingProfile', [GophishController::class, 'getSendingProfile'])->name('getSendingProfile');
        Route::post('/createSendingProfile', [GophishController::class, 'createSendingProfile'])->name('createSendingProfile');
        Route::post('/updateSendingProfile', [GophishController::class, 'updateSendingProfile'])->name('updateSendingProfile');
        Route::post('/deleteSendingProfile', [GophishController::class, 'deleteSendingProfile'])->name('deleteSendingProfile');
        Route::post('/activateSendingProfile', [GophishController::class, 'activateSendingProfile'])->name('activateSendingProfile');
    });

});
