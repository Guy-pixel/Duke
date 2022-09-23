<?php

use App\Http\Controllers\UserController;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifySongController;
use Illuminate\Support\Facades\Session;
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
Route::middleware('SpotifyConnect')->get('/connect', function (){

});
Route::get('next', [SpotifySongController::class, 'nextSong']);
Route::get('previous/{username}', function($username){
    $spotifyUser = SpotifyUser::where('username', $username)->first();
    SpotifySongController::previousSong($spotifyUser->getAttributes()['access_token'], $spotifyUser->getAttributes()['refresh_token']);
});
Route::get('resume', [SpotifySongController::class, 'resumeSong']);
Route::get('pause', [SpotifySongController::class, 'pauseSong']);

Route::post('checkUser', [UserController::class, 'checkUser']);



