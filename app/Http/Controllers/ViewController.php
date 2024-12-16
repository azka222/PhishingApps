<?php

namespace App\Http\Controllers;

class ViewController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function userSettingView(){
        return view('contents.user-setting');
    }
}
