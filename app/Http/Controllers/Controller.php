<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
}
