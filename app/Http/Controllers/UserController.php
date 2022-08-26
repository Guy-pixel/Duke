<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function signup(Request $request){
        $fields = $request->except('_token');
        $currentUser = new User($fields);
        $currentUser->save();
    }
}
