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


    if (isset($_SESSION['userToken'])) {
        dump($_SESSION['userToken']);
    } elseif (isset($_GET['code'])) {
        $currentUser = new SpotifyUser();
        $_SESSION['userToken'] = $currentUser->getUserToken($_GET['code'], $devApp->client_id, $devApp->client_secret);
        echo '<strong>User Code: </strong>' . $_GET['code'] . '<br/>';
        redirect('/');
    } else {
        echo("<a href='https://accounts.spotify.com/authorize?" . $devApp->createAuthorizationLink() . "'>Log Into Spotify</a>");
    }



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
    <?php
    if (isset($currentUser->accessToken) && $currentUser != "") {
        $deviceList = $currentUser->getDevices()->devices;
        dump($deviceList);
        echo '<br/>';
        foreach ($deviceList as $key => $device) {
            if ($device->is_active) {
                $activeDevice = [
                    'id' => $device->id,
                    'name' => $device->name,
                ];
            }
        }

    }
    ?>
</x-layout>
