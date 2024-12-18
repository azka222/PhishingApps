<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfileDetails()
    {
        $user = User::getProfileDetails();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|regex:/^08[0-9]{8,}$/',
            'gender' => 'required|string',
        ]);

        $user = User::findOrFail($request->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
        ]); 
    }
}
