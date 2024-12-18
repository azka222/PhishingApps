<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use Carbon\Carbon;

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
        $user->company_id = $request->company;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();

        $checkUser = User::where('company_id', $request->company)->count();
        if ($checkUser == 1) {
            $company = Company::findOrFail($request->company);
            $company->user_id = $user->id;
            $company->save();
        }

        event(new Registered($user));

        return response()->json([
            'message' => 'User created successfully',
        ], 200);
    }

    public function sendOtp(Request $request)
    {
        $user = auth()->user();
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(5);
        $user->save();
        Mail::to(auth()->user()->email)->send(new OtpEmail($otp));
        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('loginView');
    }

    public function resendOtp(Request $request)
    {
        $user = auth()->user();
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(5);
        $user->save();
        Mail::to(auth()->user()->email)->send(new OtpEmail($otp));
        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6|min:6|max:6', 
        ]);
        $user = auth()->user();
        if ($user->otp_expired_at < Carbon::now()) {
            return response()->json(['message' => 'OTP is expired'], 400);
        }
        if ($user->otp != $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
        $user->otp = null;
        $user->otp_expired_at = null;
        $user->save();
        return response()->json(['message' => 'OTP is valid']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);
        $user = auth()->user();
        if (password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Can not use the same password!'], 400);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['message' => 'Password changed successfully']);
    }
}
