<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);
Route::get('/login', [ViewController::class, 'loginView'])->name('authView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});



