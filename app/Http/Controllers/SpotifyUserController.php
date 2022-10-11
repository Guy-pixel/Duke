<?php

namespace App\Http\Controllers;
use App\Models\SpotifyUser;
use App\Models\SpotifyDev;
use App\Models\User;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

// @todo #marek make sure to keep your code tidy! Have a squizz through https://www.php-fig.org/psr/psr-1/
class SpotifyUserController extends Controller
{
    // @todo #marek make sure to specify the scope of the function public/protected/private
    static function connectAccount(User $user, SpotifyDev $devApp){
        $spotifyUser = self::createUser($devApp);

        // @todo #marek there is so much space for activities!

    }
    static function SSO(){
        $currentUser = new SpotifyUser();
    }

    /**
     * Creates a redirect to the authorization link.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    // @todo #marek you should try to limit what is being returned to one type of object. and also keep to the 120 limit
    static function signInPopup(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
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
     * @return SpotifyUser
     */
    static function createUser(string $code): SpotifyUser
    {
        // @todo #marek i have noticed you have a lot static functions and creating new objects inside the function.
        //      These are called hard dependencies. You can use a factory to have the SpotifyUser be a parameter
        //      in the object.
        //      Have a look at the ezyVet code: \InsuranceIntegration\Offer\Service\OfferTypeMenuServiceFactory
        //      and: \InsuranceIntegration\Offer\Service\OfferTypeMenuService
        //      @link https://olegkrivtsov.github.io/using-zend-framework-3-book/html/en/Model_View_Controller/Controller_Registration.html
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
                'expiry_time'=>date("Y-m-d H:i:s", substr($currentUser->expiry_time, 0, 10))
            ]);
        } else {
            // refresh or re-request access token12122

            try{
                $existingUser->refreshAccessToken();
            }catch(Exception $e){
                return 'Existing User Found' . $e->getMessage();
            }

        }
        return $currentUser;
    }
}
