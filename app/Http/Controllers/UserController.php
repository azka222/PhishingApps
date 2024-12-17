<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfileDetails(){
        $user = User::getProfileDetails();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
