<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>
    <?php
    $sessionSpotifyUser=session('spotifyUser');

    if(isset($spotifyUser['username'])){
        $spotifyUser=SpotifyUser::where('username', $spotifyUser['username'])->first();
        $spotifyUserId=$spotifyUser->getId();
    } else {
        $spotifyUserId=NULL;
    }

    $username = Null;
    ?>

    <x-nav-bar :user="$username"></x-nav-bar>

    <x-side-bar></x-side-bar>
    <div class="inline-view">

        <a href="/connect">Connect to Spotify</a>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
        <x-voting-card></x-voting-card>
    </div>
    <x-media-bar :spotifyUserId="$spotifyUserId"></x-media-bar>


</x-layout>
