<?php
use App\Models\Song;
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SpotifySongController;
session_start();
?>

<x-layout>
    <?php
    $sessionSpotifyUser = session('spotifyUser');
    if (isset($sessionSpotifyUser['username'])) {
        $spotifyUser = SpotifyUser::where('username', '=', $sessionSpotifyUser['username'])->first();
        SpotifySongController::getAlbum($spotifyUser);
    } else {
        $spotifyUser=NULL;
    }

    $username = Null;
    $songs = Song::all();

    ?>
    <x-nav-bar :user="$username"></x-nav-bar>

    <x-side-bar></x-side-bar>
    <div class="inline-view">
        <div id="votinglistroot"></div>
    </div>
    <x-media-bar :spotifyUser="$spotifyUser"></x-media-bar>


</x-layout>
