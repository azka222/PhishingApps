<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;


Route::get('/auth', [ViewController::class, 'loginView'])->name('authView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});


