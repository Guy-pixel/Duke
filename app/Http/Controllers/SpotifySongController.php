<?php

namespace App\Http\Controllers;

use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;

class SpotifySongController extends Controller
{
    public function testResponse()
    {
        return array(
            'id' => '1',
            'name' => 'guy',
            'lastname' => 'gasson'
        );
    }

    public function nextSong()
    {
        session_start();
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->next();
        session_abort();
    }

    public function previousSong()
    {
        session_start();
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->previous();
        session_abort();
    }

    public function resumeSong()
    {
        session_start();
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->resume();
        session_abort();
    }

    public function pauseSong()
    {
        session_start();
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->pause();
        session_abort();
    }



}
