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
<<<<<<< Updated upstream
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->next();
=======
        $currentUser = new SpotifyUser($_SESSION['access_token'], '');
        $currentUser->skipToNext();
>>>>>>> Stashed changes
        session_abort();
    }

    public function previousSong()
    {
        session_start();
<<<<<<< Updated upstream
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
        $currentUser->previous();
=======
        $currentUser = new SpotifyUser($_SESSION['access_token'], '');
        $currentUser->skipToPrevious();
>>>>>>> Stashed changes
        session_abort();
    }

    public function resumeSong()
    {
        session_start();
<<<<<<< Updated upstream
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
=======
        $currentUser = new SpotifyUser($_SESSION['access_token'], '');
>>>>>>> Stashed changes
        $currentUser->resume();
        session_abort();
    }

    public function pauseSong()
    {
        session_start();
<<<<<<< Updated upstream
        $currentUser = new SpotifyUser($_SESSION['access_token'], $_SESSION['refresh_token']);
=======
        $currentUser = new SpotifyUser($_SESSION['access_token'], '');
>>>>>>> Stashed changes
        $currentUser->pause();
        session_abort();
    }



}
