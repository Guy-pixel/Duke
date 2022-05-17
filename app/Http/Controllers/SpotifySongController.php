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
        $currentUser = new SpotifyUser('', '', $_SESSION['userToken']->access_token);
        $currentUser->skipToNext();
    }

    public function previousSong()
    {
        session_start();
        $currentUser = new SpotifyUser('', '', $_SESSION['userToken']->access_token);
        $currentUser->skipToPrevious();
    }

    public function resumeSong()
    {
        session_start();
        $currentUser = new SpotifyUser('', '', $_SESSION['userToken']->access_token);
        $currentUser->resume();
    }

    public function pauseSong()
    {
        session_start();
        $currentUser = new SpotifyUser('', '', $_SESSION['userToken']->access_token);
        $currentUser->pause();
    }



}
