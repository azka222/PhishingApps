<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [ViewController::class, 'loginView'])->name('login');
Route::get('/register', [ViewController::class, 'registerView'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login'])->name('tryLogin');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});


