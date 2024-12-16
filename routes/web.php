<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/login', [ViewController::class, 'loginView'])->name('authView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});
