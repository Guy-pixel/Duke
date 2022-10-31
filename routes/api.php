<?php

use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifySongController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('SpotifyConnect')->get('/connect', function () {

});
Route::get('next/{username}', function($username){
    $spotifyUser = SpotifyUser::where('username', $username)->first();
    SpotifySongController::nextSong($spotifyUser);
});
Route::get('previous/{username}', function ($username) {
    $spotifyUser = SpotifyUser::where('username', $username)->first();
    SpotifySongController::previousSong($spotifyUser);
});
Route::get('resume/{username}', function ($username) {
    $spotifyUser = SpotifyUser::where('username', $username)->first();
    SpotifySongController::resumeSong($spotifyUser);
});

Route::get('pause/{username}', function($username){
    $spotifyUser = SpotifyUser::where('username', $username)->first();
    SpotifySongController::pauseSong($spotifyUser);
});
Route::get('vote/{songId}', function($songId){

});
Route::get('songlist', function(){

    return SongController::getAllSongs()->toArray();
});

Route::post('checkUser', [UserController::class, 'checkUser']);



