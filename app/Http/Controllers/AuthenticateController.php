<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ForgotPasswordJob;
use App\Jobs\SendOTPJob;
use App\Jobs\SendRegistrationEmailJob;
use App\Jobs\SendVerificationEmailJob;
use App\Models\Company;
use App\Models\EmployeeAccount;
use App\Models\ModuleAbility;
use App\Models\Role;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticateController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (! auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Cannot find user with provided credentials'],
            ]);
        }

        $user = auth()->user();
        if (! $user->hasVerifiedEmail()) {
            auth()->logout();
            SendVerificationEmailJob::dispatch($user);
            return response()->json(['message' => 'Please verify your email address.'], 400);
        } else {
            return auth()->user()->canAccessDashboard()
            ? redirect()->route('dashboard')
            : redirect()->route('userSettingView');

        }

    }

    public function register(Request $request)
    {

        $request->validate([
            'first_name'            => 'required|string',
            'last_name'             => 'required|string',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|string|min:6',
            'company'               => 'required|string',
            'phone'                 => 'required|string|regex:/^08[0-9]{8,}$/',
            'password_confirmation' => 'required|same:password',
            'gender'                => 'required|string',
        ]);
        $user             = new User();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->password   = bcrypt($request->password);
        $user->company_id = $request->company;
        $user->phone      = $request->phone;
        $user->gender     = $request->gender;
        $user->is_admin   = 0;

        // $company = Company::findOrFail($request->company);
        // $customDomain = $company->custom_domain;
        // if ($customDomain == 1) {
        //     $companyEmail = $company->email;
        //     $companyDomain = explode('@', $companyEmail)[1];
        //     $userDomain = explode('@', $request->email)[1];

        //     if ($companyDomain !== $userDomain) {
        //     return response()->json([
        //         'message' => 'Email domain must match company domain.',
        //         'errors' => [
        //         'email' => ['Email domain must match company domain.']
        //         ]
        //     ], 400);
        //     }
        // }
        $user->save();

        $checkUser = User::where('company_id', $request->company)->count();
        if ($checkUser == 1) {
            $company            = Company::findOrFail($request->company);
            $company->user_id   = $user->id;
            $company->status_id = 1;
            $company->save();
            $role                = new Role();
            $role->name          = 'Company Admin';
            $role->company_id    = $request->company;
            $role->company_admin = 1;
            $role->save();
            $user->role_id = $role->id;
            $user->save();
            $moduleAbilities = ModuleAbility::all()->pluck('id');
            $role->moduleAbility()->syncWithoutDetaching($moduleAbilities);

            $userRole                = new Role();
            $userRole->name          = 'User';
            $userRole->company_id    = $request->company;
            $userRole->company_admin = 0;
            $userRole->save();
        } else {
            $userRole = Role::where('company_id', $request->company)->where('company_admin', 0)->first();
            if (! $userRole) {
                $userRole                = new Role();
                $userRole->name          = 'User';
                $userRole->company_id    = $request->company;
                $userRole->company_admin = 0;
                $userRole->save();
            }
            $user->role_id = $userRole->id;
            $user->save();
        }

        SendRegistrationEmailJob::dispatch($user);

        return response()->json([
            'message' => 'User created successfully',
        ], 200);
    }

    public function sendOtp(Request $request)
    {
        $user                 = auth()->user();
        $otp                  = rand(100000, 999999);
        $user->otp            = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(1);
        $user->save();
        SendOTPJob::dispatch(auth()->user()->email, $otp);
        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('loginView');
    }

    public function resendOtp(Request $request)
    {
        $user                 = auth()->user();
        $otp                  = rand(100000, 999999);
        $user->otp            = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(5);
        $user->save();
        SendOTPJob::dispatch(auth()->user()->email, $otp);
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
        $user->otp            = null;
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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user                 = User::where('email', $request->email)->first();
        $token                = sha1(time());
        $user->reset_token    = $token;
        $user->otp_expired_at = Carbon::now()->addMinutes(5);
        $user->save();

        $resetUrl = url('/reset-password?token=' . $token);
        ForgotPasswordJob::dispatch($user->email, $resetUrl);
        return response()->json(['message' => 'Reset password link sent to your email']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('reset_token', $request->token)
            ->where('otp_expired_at', '>=', Carbon::now())
            ->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        $user->password         = bcrypt($request->password);
        $user->reset_token      = null;
        $user->token_expiration = null;
        $user->save();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:6',
        ]);

        $user = User::where('reset_token', $request->token)
            ->where('otp_expired_at', '>=', now())
            ->first();

        if (! $user) {
            return redirect('/')->with('error', 'Invalid or expired token.');
        }

        $user->password       = bcrypt($request->password);
        $user->reset_token    = null;
        $user->otp_expired_at = null;
        $user->save();
        return response()->json(['message' => 'Password has been reset successfully.']);
    }

    public function sendEmployeeOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = Target::where('email', $request->email)->where('account', 1)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 400);
        }
        $id      = $user->id;
        $account = EmployeeAccount::where('target_id', $id)->first();
        if (! $account) {
            return response()->json(['message' => 'User not found'], 400);
        }
        $otp                     = rand(100000, max: 999999);
        $account->otp            = $otp;
        $account->otp_expired_at = Carbon::now()->addMinutes(5);
        $account->save();
        SendOTPJob::dispatch($user->email, $otp);
        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function loginEmployee(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $user = Target::where('email', $request->email)->where('account', 1)->first();
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Cannot find user with provided credentials'],
            ]);
        }
        $account = EmployeeAccount::where('target_id', $user->id)->first();
        if (! $account) {
            throw ValidationException::withMessages([
                'email' => ['Cannot find user with provided credentials'],
            ]);
        }
        if ($account->otp_expired_at < Carbon::now()) {
            return response()->json(['message' => 'OTP is expired'], 400);
        }
        if ($account->otp != $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'Login successful'], 200);
    }

    public function checkAccountEmployee(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->where('employee', 1)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 400);
        }
        $checkPassword = User::where('email', $request->email)->where('reset_password', 0)->first();
        if ($checkPassword) {
            return response()->json([
                'message' => 'User found, please reset your password',
                'status'  => 'reset_password',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User found, please login',
                'status'  => 'login',
            ], 200);
        }
    }

    public function loginEmployeeAccount(Request $request)
    {
        if ($request->employeeLogin == 'reset_password') {
            $email           = $request->data['email'];
            $oldPassword     = $request->data['password'];
            $newPassword     = $request->data['new_password'];
            $confirmPassword = $request->data['confirm_password'];
            if ($newPassword != $confirmPassword) {
                return response()->json(['message' => 'New password and confirm password do not match'], 400);
            }
            if ($email == null || $oldPassword == null || $newPassword == null || $confirmPassword == null) {
                return response()->json(['message' => 'Please fill all the fields'], 400);
            }

            $user = User::where('email', $email)->first();
            if (! $user) {
                return response()->json(['message' => 'User not found'], 400);
            }
            if (! password_verify($oldPassword, $user->password)) {
                return response()->json(['message' => 'Old password is incorrect'], 400);
            }
            $user->password       = bcrypt($newPassword);
            $user->reset_password = 1;
            $user->save();
        }
        if ($request->employeeLogin == 'login') {
            $email       = $request->data['email'];
            $password    = $request->data['password'];
            if ($email == null || $password == null) {
                return response()->json(['message' => 'Please fill all the fields'], 400);
            }
            $user = User::where('email', $email)->first();
            if (! $user) {
                return response()->json(['message' => 'User not found'], 400);
            }
            if (! password_verify($password, $user->password)) {
                return response()->json(['message' => 'Password is incorrect'], 400);
            }
        }
        $user->email_verified_at = Carbon::now();
        $user->save();
        Auth::login($user);

        return redirect()->route('employeeDashboardView');
    }

}
