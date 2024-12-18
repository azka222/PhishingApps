<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ViewController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\UserController;

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
    return  redirect()->route('login');
})->middleware(['signed'])->name('verification.verify');
Route::get('/login', [ViewController::class, 'loginView'])->middleware('guest')->name('loginView');
Route::get('/register', [ViewController::class, 'registerView'])->middleware('guest')->name('registerView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');
Route::get('/getCompanies', [CompanyController::class, 'getCompanies'])->name('getCompanies');
Route::post('/checkCompanies', [CompanyController::class, 'checkCompany'])->name('checkCompany');
Route::post('/createCompany', [CompanyController::class, 'createCompany'])->name('createCompany');




// ==================================== if user login success ====================================
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('contents.dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'user-setting'], function () {
        Route::get('/', [ViewController::class, 'userSettingView'])->name('userSettingView');
        Route::get('/getProfileDetails', [UserController::class, 'getProfileDetails'])->name('getProfileDetails');
        Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');
    });

});
