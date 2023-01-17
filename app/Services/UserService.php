<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function checkUser(string $username){
        return User::where('username', $username)->first();
    }
    public function loginUser(User $user, string $password){
        if(!Hash::check($password,$user->password)){
            return false;
        }
        Auth::login($user);
        return true;
    }
}
