<?php

namespace App\Http\Controllers;
use App\Models\SpotifyUser;
use App\Models\SpotifyDev;
use App\Models\User;
use Illuminate\Http\Request;

class SpotifyUserController extends Controller
{

    static function connectAccount(User $user, SpotifyDev $devApp){
        $currentUser = self::createUser($devApp);



    }
    static function SSO(){
        $currentUser = new SpotifyUser();
    }
    static function createUser($token){
        $currentUser = new SpotifyUser();
        $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'));
        return redirect($devApp->createAuthorizationLink());
        $currentUser->requestAccessToken(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            $token
        );

        dd($currentUser);
        $existingUser = SpotifyUser::where('username', $currentUser->getUsername())->first();
        if(!isset($existingUser)){
            $currentUser->save();
        } else {
            // refresh or re-request access token

        }
        return $currentUser;
    }
}
