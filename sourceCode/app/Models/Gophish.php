<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Gophish extends Model
{
    // public static function createUser($user)
    // {
    //     $company = Company::find($user->company_id)->user_id;
    //     if ($company != $user->id) {
    //         $role = [
    //             'slug' => 'user',
    //             'name' => 'User',
    //             'description' => 'User',
    //         ];
    //     } else {
    //         $role = [
    //             'slug' => 'admin',
    //             'name' => 'Admin',
    //             'description' => 'User Admin',
    //         ];
    //     }
    //         $response = Http::withHeaders([
    //             'Authorization' => env('GOPHISH_API_KEY'),
    //         ])->post("http://127.0.0.1:3333/api/users", [
    //             'id' => $user->id,
    //             'username' => $user->email,
    //             'role' => $role,
    //         ], );
    //         dd($response->status(), $response->body());
    // }
}
