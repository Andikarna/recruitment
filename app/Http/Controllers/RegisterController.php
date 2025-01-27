<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class RegisterController extends Controller
{
    public function register(){
        // $user = User::create([
        //     'name' => "Junus",
        //     'role_id' => 4,
        //     'email' => "Junus@adidata.co.id",
        //     'password' => Hash::make(123123),
        // ]);

        // $user->save();

    }
}
