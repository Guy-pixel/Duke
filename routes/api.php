<?php

use App\Http\Controllers\UserController;
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
Route::middleware('SpotifyConnect')->get('/connect', function (){

});
Route::get('test', [SpotifySongController::class, 'testResponse']);
Route::get('next', [SpotifySongController::class, 'nextSong']);
Route::get('previous', [SpotifySongController::class, 'previousSong']);
Route::get('resume', [SpotifySongController::class, 'resumeSong']);
Route::get('pause', [SpotifySongController::class, 'pauseSong']);

Route::post('checkUser', [UserController::class, 'checkUser']);



