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

    public static function previousSong(SpotifyUser $spotifyUser)
    {
        $currentUser = new SpotifyUser($spotifyUser->getAccessToken(), $spotifyUser->getRefreshToken());
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
