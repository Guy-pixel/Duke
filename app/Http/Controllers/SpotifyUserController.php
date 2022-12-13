<?php

namespace App\Http\Controllers;
use App\Models\CurlObject;
use App\Models\SpotifyUser;
use App\Models\SpotifyDev;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// @todo #marek make sure to keep your code tidy! Have a squizz through https://www.php-fig.org/psr/psr-1/
class SpotifyUserController
{
    public static function connectAccount(User $user, SpotifyDev $devApp){
        $spotifyUser = self::createUser($devApp);

        // @todo #marek there is so much space for activities!

    }
    public static function SSO(){
        $currentUser = new SpotifyUser();
        if($currentUser->getUsername() !== null){
            $connectedUser = new User($currentUser);
            User::verify($currentUser);
            $request = new CurlObject(
                'https://accounts.spotify.com/api/token',
                'POST',
                [
                    'Authorization: Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID') . ':' . env('SPOTIFY_CLIENT_SECRET')),
                    'Content-Type:application/x-www-form-urlencoded'
                ],
                [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $currentUser->refresh_token
                ]
            );


        }
    }

    /**
     * Creates a redirect to the authorization link.
     * @return RedirectResponse
     */

    public static function signInPopup(): RedirectResponse
    {
        // #marek good use of security with not unveiling keys ;)
        $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'));
        return redirect($devApp->createAuthorizationLink());

    }

    /**
     * Creates a user based on the spotify redirect code.
     * If it's a duplicate, attempt to refresh the access token.
     *
     * @param string $code
     * @return string
     */
    public static function createUser(string $code)
    {
        $currentUser = new SpotifyUser();
        $currentUser->requestAccessToken(env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            $code
        );
        $currentUser->requestUserInfo();
        $existingUser = SpotifyUser::where('username', $currentUser->username)->first();
        if(!isset($existingUser)){
            SpotifyUser::create([
                'username'=>$currentUser->username,
                'access_token'=>$currentUser->access_token,
                'refresh_token'=>$currentUser->refresh_token,
                'expiry_time'=>date("Y-m-d H:i:s", intval(substr($currentUser->getExpiryTime(), 0, 10)))
            ]);
        } else {
            // refresh or re-request access token

            try{
                $existingUser->refreshAccessToken();
            }catch(\Exception $e){

            }

        }
        return $currentUser;
    }
}
