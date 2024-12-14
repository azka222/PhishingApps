<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        dd($request->all());
        // $credentials = $request->only('email', 'password');
        // if (auth()->attempt($credentials)) {
        //     return redirect()->route('dashboard');
        // }
        // return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'company' => 'required|string',
            'phone' => 'required|string|regex:/^08[0-9]{8,}$/',
            'password_confirmation' => 'required|same:password',
            'gender' => 'required|string',
        ])->validate();

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); 
        }
    }
}
