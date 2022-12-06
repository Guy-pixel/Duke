<?php

use App\Http\Controllers\SpotifyUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home_updated');
})->name('home');
Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
})->name('signup');
Route::post('/signup/request', function (Request $request) {
    $ifError = UserController::signup($request);
    if (isset($ifError['code'])) {

        $request->session()->flash('message', 'Credentials not found');
    }
    return redirect('/');
});
Route::post('login', [UserController::class, 'loginUser']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('connect', function () {
    return SpotifyUserController::signInPopup(session('devToken'));
});
Route::get('spotifyRedirect', [SpotifyDriver::class, 'callbackResponse']);

