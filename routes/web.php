<?php

use Illuminate\Support\Facades\Route;

// $app->router->get('/', function () {
//     return redirect('/login'); // Redirect ke halaman login
// })->middleware('auth');

// $app->router->get('/login', function () {
//     return view('auth.login'); // Halaman login
// });

Route::get('/', function () {
    return redirect('/login'); 
})->middleware('auth');