<?php

namespace App\Http\Controllers;

use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;

class SpotifySongController extends Controller
{

    public static function nextSong($accessToken, $refreshToken)
    {
        $currentUser = new SpotifyUser('',$accessToken, $refreshToken);
        $currentUser->next();
    }

    public static function previousSong($accessToken, $refreshToken)
    {
        $currentUser = new SpotifyUser('',$accessToken, $refreshToken);
        $currentUser->previous();
    }

    public static function resumeSong(SpotifyUser $spotifyUser)
    {
        $spotifyUser->resume();
    }

    public static function pauseSong($accessToken, $refreshToken)
    {
        $currentUser = new SpotifyUser('',$accessToken, $refreshToken);
        $currentUser->pause();
    }



}
