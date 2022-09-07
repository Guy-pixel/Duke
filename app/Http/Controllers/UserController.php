<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public static function signup(Request $request)
    {
        $fields = $request->except('_token');
        $currentUser = new User($fields);
        $currentUser->save();
    }

    public static function checkUser(Request $request)
    {
        $fields = $request->except('_token');
        User::query();
    }

    public static function deleteUser($userID = NULL, $userName = NULL, $userEmail = NULL)
    {
        if(isset($userID)){
            $selectedUser = User::find($userID);
            $selectedUser->delete();
        }elseif(isset($userName)){
            $selectedUser = User::find($userName);
            $selectedUser->delete();
        }elseif(isset($userEmail)){
            $selectedUser = User::find($userEmail);
            $selectedUser->delete();
        }else{
            $error = new \InvalidArgumentException('No parameters given.', 404);
        }


    }
}
