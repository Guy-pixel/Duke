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
