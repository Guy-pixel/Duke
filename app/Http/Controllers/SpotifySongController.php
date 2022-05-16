<?php

namespace App\Http\Controllers;

use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;

class SpotifySongController extends Controller
{
    public function testResponse(){
        return array(
            'id' => '1',
            'name' => 'guy',
            'lastname'=> 'gasson'
        );
    }
    public function skipSong(){
        session_start();
        $currentUser = new SpotifyUser('','',$_SESSION['userToken']->access_token);
        $currentUser->skipToNext();
    }
}
