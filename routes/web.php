<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ViewController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

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
Route::get('/login', [ViewController::class, 'loginView'])->name('authView');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return view('contents.dashboard');
    })->name('dashboard');
});
