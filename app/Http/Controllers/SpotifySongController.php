<?php

namespace App\Http\Controllers;

use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;

class SpotifySongController extends Controller
{

    public static function nextSong(SpotifyUser $spotifyUser)
    {
        $spotifyUser->next();
    }

    public static function previousSong(SpotifyUser $spotifyUser)
    {
        $spotifyUser->previous();
    }

    public static function resumeSong(SpotifyUser $spotifyUser)
    {
        $spotifyUser->resume();
    }

    public static function pauseSong(SpotifyUser $spotifyUser)
    {
        $spotifyUser->pause();
    }



}
