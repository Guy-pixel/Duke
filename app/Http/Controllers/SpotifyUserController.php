<?php

namespace App\Http\Controllers;
use App\Models\SpotifyUser;
use App\Models\SpotifyDev;
use App\Models\User;
use Illuminate\Http\Request;

class SpotifyUserController extends Controller
{

    static function connectAccount(User $user, SpotifyDev $devApp){
        $currentUser = new SpotifyUser();
        $currentUser->requestAccessToken(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            $devApp->getToken());
        $existingUser = SpotifyUser::where('username', $currentUser->getUsername())->first();
        if(!isset($existingUser)){
            $currentUser->save();
        } else {
            // refresh or re-request access token
        }



    }
}
