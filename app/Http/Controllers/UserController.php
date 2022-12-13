<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public static function signup(Request $request)
    {
        $fields = $request->except('_token');
        $currentUser = new User($fields);
        try {
            $currentUser->save();
        } catch (QueryException $e) {
            return [
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
            ];
        }
    }

    public static function checkUser(Request $request)
    {
        $fields = $request->except('_token');
        $username = $fields->username;

        if (isset($username)) {
            $user = User::where('username', $fields->username());
        } elseif (isset($email)) {
            $user = User::where('email', $fields->email());
        }
        if (isset($user)) {
            return $user;
        } else {
            return 'user not found';
        }
    }

    public static function loginUser(Request $request, UserService $userService)
    {
        $user = $userService->checkUser($request->input('username'));
        if(!$user) {
            $request->session()->flash('message', 'Credentials Not Found');
            return back();
        }
        if(!$userService->loginUser($user, $request->input('password'))){
            $request->session()->flash('message', 'Credentials Not Found');
            return back();
        }
        return redirect('/');
    }
    public static function logout(){
        Auth::logout();
        return back();
    }
    public static function deleteUser($userID = NULL, $userName = NULL, $userEmail = NULL)
    {
        if (isset($userID)) {
            $selectedUser = User::find($userID);
            $selectedUser->delete();
        } elseif (isset($userName)) {
            $selectedUser = User::find($userName);
            $selectedUser->delete();
        } elseif (isset($userEmail)) {
            $selectedUser = User::find($userEmail);
            $selectedUser->delete();
        } else {
            $error = new \InvalidArgumentException('No parameters given.', 404);
        }


    }
}
