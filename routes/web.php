<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();   
    return redirect('/login')->with('message', 'Email successfully verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/login', [ViewController::class, 'loginView'])->name('authView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});



