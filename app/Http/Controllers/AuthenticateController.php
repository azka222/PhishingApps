<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'company' => 'required|string',
            'phone' => 'required|string|regex:/^08[0-9]{8,}$/',
            'password_confirmation' => 'required|same:password',
            'gender' => 'required|string',
        ]);
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->company = $request->company;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();

        $user->sendEmailVerificationNotification();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Please verify your email!',
            ], 401);
        } else {
            return response()->json([
                'message' => 'Registration successful!',
            ], 200);
        }

    }
}
