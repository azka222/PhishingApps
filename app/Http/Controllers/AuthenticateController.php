<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Cannot find user with provided credentials'],
            ]);
        }
        
        $user = auth()->user();
        if (!$user->hasVerifiedEmail()) {
            event(new Registered($user));
            throw ValidationException::withMessages([
                'email' => ['Your email isn’t verified yet. Please check your inbox and verify your email to continue'],
            ]);
        }


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

        // $user->sendEmailVerificationNotification();
        event(new Registered($user));

        return response()->json([
            'message' => 'User created successfully'
        ], 200);

    }
}
