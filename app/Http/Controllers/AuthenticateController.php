<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
}
