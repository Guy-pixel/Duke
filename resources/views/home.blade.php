<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>

    <?php

    $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'));
    $devApp->getToken();



    echo("<a href='https://accounts.spotify.com/authorize?" . $devApp->createAuthorizationLink() . "'>Log Into Spotify</a>");




    ?>
    <script>
        function playerPause() {
            fetch('http://127.0.0.1:8000/api/pause');
        }
        function playerResume() {
            fetch('http://127.0.0.1:8000/api/resume')
        }
        function playerSkip() {
            fetch('http://127.0.0.1:8000/api/skip')
        }
        function playerPrevious() {
            fetch('http://127.0.0.1:8000/api/previous')
        }
    </script>
    <div>
        <button onclick="playerPause()">Pause</button>
        <button onclick="playerResume()">Resume</button>
        <button onclick="playerPrevious()">Previous</button>
        <button onclick="playerSkip()">Skip</button>
    </div>
</x-layout>
