<?php

use App\Http\Controllers\SpotifyUserController;
use App\Models\SpotifyUser;
use App\Models\User;
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
//        $stringifiedError = '?message=' . $ifError['message'];
        $request->session()->flash('message', 'Credentials not found');
    }
    return redirect('/');
});
Route::post('login', [UserController::class, 'loginUser']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('connect', function () {
    return SpotifyUserController::signInPopup(session('devToken'));
});
Route::get('spotifyRedirect', function () {
    if ($_GET['code']) {
        $createdSpotifyUser = SpotifyUserController::createUser($_GET['code']);
        session(['spotifyUser' => [
            'username' => $createdSpotifyUser->getUsername(),
            'access_token' => $createdSpotifyUser->getAccessToken(),
            'refresh_token' => $createdSpotifyUser->getRefreshToken(),
            'expiry_time' => $createdSpotifyUser->getExpiryTime()
        ]]);
        $dbSpotifyUser=SpotifyUser::where('username', $createdSpotifyUser->getUsername())->first();
        if(Auth::user()){
            $loggedInUser = User::where('id', Auth::id())->first();
            $loggedInUser->setSpotifyId($dbSpotifyUser->getId());

        }
    }

    return redirect('/');
});
//
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
