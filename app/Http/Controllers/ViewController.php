<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function userSettingView()
    {
        return view('contents.user-setting');
    }

    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    public function resetPasswordView(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return redirect('/')->with('error', 'Invalid token.');
        }
        return view('auth.reset-password', ['token' => $token]);
    }

    public function targetView()
    {
        return view('contents.target');
    }

    public function groupView()
    {
        return view('contents.group');
    }

    public function landingPageView()
    {
        return view('contents.landing-page');
    }

    public function emailTemplatesView()
    {
        return view('contents.email-templates');
    }
}
