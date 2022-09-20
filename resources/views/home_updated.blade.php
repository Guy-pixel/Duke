<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>
    <?php
    $spotifyUser = unserialize(session('createdUser'));
    $username=$spotifyUser->getUsername();
    if(isset($username)){
    dd($spotifyUser);
    }
    $username = NULL;

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
    <x-media-bar></x-media-bar>


</x-layout>
