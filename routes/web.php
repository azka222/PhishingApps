<?php

use App\Http\Controllers\AuthenticateController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthenticateController::class, 'loginView'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});


