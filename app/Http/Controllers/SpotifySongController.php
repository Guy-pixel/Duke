<?php

namespace App\Http\Controllers;

use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;

class SpotifySongController extends Controller
{

    public static function nextSong()
    {
        $currentUser = new SpotifyUser(session('spotifyUser')['access_token'], session('spotifyUser')['refresh_token']);
        $currentUser->next();
    }

    public static function previousSong($accessToken, $refreshToken)
    {
        $currentUser = new SpotifyUser($accessToken, $refreshToken);
        $currentUser->previous();
    }

    public static function resumeSong()
    {
        $currentUser = new SpotifyUser(session('spotifyUser')['access_token'], session('spotifyUser')['refresh_token']);
        $currentUser->resume();
    }

    public static function pauseSong()
    {
        $currentUser = new SpotifyUser(session('spotifyUser')['access_token'], session('spotifyUser')['refresh_token']);
        $currentUser->pause();
    }



}
