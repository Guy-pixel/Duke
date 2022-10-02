<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>
    <?php
    $sessionSpotifyUser = session('spotifyUser');
    if (isset($sessionSpotifyUser['username'])) {
        $spotifyUser = SpotifyUser::where('username', '=', $sessionSpotifyUser['username'])->first();;
        if (isset($spotifyUser->getAttributes()['username'])) {
            $spotifyUserId = $spotifyUser->getAttributes()['username'];
        } else {
            $spotifyUserId = NULL;
        }
    } else {
        $spotifyUserId = NULL;
    }

    $username = Null;
    ?>

    <x-nav-bar :user="$username"></x-nav-bar>

    <x-side-bar></x-side-bar>
    <div class="inline-view">
        @if(!isset($spotifyUserId))
            <a href="/connect">Connect to Spotify</a>
        @else
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
            <x-voting-card></x-voting-card>
        @endif
    </div>
    <x-media-bar :spotifyUserId="$spotifyUserId"></x-media-bar>


</x-layout>
