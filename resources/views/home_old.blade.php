<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>
    <script>
        function playerPause() {
            fetch('http://127.0.0.1:8000/api/pause');
        }

        function playerResume() {
            fetch('http://127.0.0.1:8000/api/resume')
        }

        function playerSkip() {
            fetch('http://127.0.0.1:8000/api/next')
        }

        function playerPrevious() {
            fetch('http://127.0.0.1:8000/api/previous')
        }
    </script>
    <?php

    $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'));
    $devApp->getToken();
    $username = NULL;
    if (!isset($_GET['code'])) {
        //echo("<a href='https://accounts.spotify.com/authorize?" . $devApp->createAuthorizationLink() . "'>Log Into Spotify</a>");
    } elseif (!isset($_SESSION['access_token'])) {
        $currentUser = new SpotifyUser();
        $currentUser->requestAccessToken($devApp->client_id, $devApp->client_secret, $_GET['code']);
        $_SESSION['access_token'] = $currentUser->getAccessToken();
        $_SESSION['refresh_token'] = $currentUser->getRefreshToken();
        $_SESSION['expiry_time'] = $currentUser->getExpiresIn();
    } else {
        $currentUser = new SpotifyUser($_SESSION['access_token'],
            $_SESSION['refresh_token'],
            $_SESSION['expiry_time']
        );
        $userInfo = $currentUser->requestUserInfo();
        echo('validated<br/>');
        echo('oauth:' . $currentUser->getAccessToken() . '<br/>');
        echo('Username:' . $currentUser->getUsername() . '<br/>');
        echo('expires in: ' . $currentUser->getExpiresIn() . '<br/>');
        echo('current time: ' . time());
        $username = $currentUser->getUsername();
    }
    ?>
    <x-nav-bar :user="$username"></x-nav-bar>

    <x-side-bar></x-side-bar>
    <div class="inline-view">
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
    </div>
    <x-media-bar></x-media-bar>


</x-layout>