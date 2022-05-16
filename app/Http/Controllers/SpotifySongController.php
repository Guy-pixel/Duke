<?php

namespace App\Http\Controllers;

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
    public function skipSong(object $currentUser){
        $currentUser->skipToNext();
    }
}
