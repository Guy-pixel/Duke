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
    static function signInPopup(){
        $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'));
        return redirect($devApp->createAuthorizationLink());
    }
    static function createUser($code){
        $currentUser = new SpotifyUser();
        $currentUser->requestAccessToken(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            $code
        );
        $currentUser->requestUserInfo();
        $existingUser = SpotifyUser::where('username', $currentUser->getUsername())->first();
        if(!isset($existingUser)){
            SpotifyUser::create([
                'username'=>$currentUser->getUsername(),
                'access_token'=>$currentUser->getAccessToken(),
                'refresh_token'=>$currentUser->getRefreshToken(),
                'expiry_time'=>date("Y-m-d H:i:s", substr($currentUser->getExpiryTime(), 0, 10))
            ]);
        } else {
            // refresh or re-request access token

        }
        return $currentUser;
    }
}
