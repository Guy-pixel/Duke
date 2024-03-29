<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class SpotifyUser extends Model
{
    use HasFactory;


    protected $fillable = [
        'username',
        'access_token',
        'refresh_token',
        'expiry_time'
    ];
    protected $dates = [
        'expiry_time',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [

    ];
    protected $table='spotify_users';

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Returns the expiry_time of the object which
     * @return int|mixed
     */
    public function getExpiryTime()
    {
        return $this->expiry_time;
    }

    /**
     * Returns the username of the object
     * @return mixed|string
     */
    public function getUsername()
    {

        return $this->username;

    }
    /**
     * Request the access token for the user and set it to the current instance
     * @param string devApp Id
     * @p aram string devApp Secret
     * @param string devApp Token
     */
    public function requestAccessToken(string $devApp_id, string $devApp_secret, string $code)
    {
        // @todo #marek this model must be having an identity crisis.
        //      See if you can move these logic into services.
        //      This looks like the same request as in \App\Models\SpotifyDev::getToken
        $requestAccess = new CurlObject(
            'https://accounts.spotify.com/api/token',
            'POST',
            [
                'Authorization: Basic ' . base64_encode($devApp_id . ':' . $devApp_secret),
                'Content-Type:application/x-www-form-urlencoded'
            ],
            [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('SPOTIFY_AUTHORIZATION_REDIRECT_URI')
            ]
        );

        $response = $requestAccess->request();


        if (!isset($response->access_token)) {
            dd($response);
        } else {
            $this->access_token = $response->access_token;
            $this->refresh_token = $response->refresh_token;
            $this->expiry_time = time() + $response->expires_in;
        }
    }

    /**
     * Requests the username of the spotify user, update later to add further information.
     *
     * @return mixed
     */
    public function requestUserInfo()
    {
        $requestUsername = new CurlObject(
            'https://api.spotify.com/v1/me',
            'GET',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json',
            ],
            []
        );
        $response = $requestUsername->request();
        if (!isset($response->id)) {
            dd($response);
        } else {
            $this->username = $response->id;
        }
        return $response;

    }

    /**
     * Refresh the access token using the refresh token.
     * @return string|void
     */
    public function refreshAccessToken()
    {
        $refreshAccessToken = new CurlObject(
            'https://accounts.spotify.com/api/token',
            'POST',
            [
                'Authorization: Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID') . ':' . env('SPOTIFY_CLIENT_SECRET')),
                'Content-Type:application/x-www-form-urlencoded'
            ],
            [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->refresh_token
            ]
        );


        try {
            $response = $refreshAccessToken->request();

            $this->access_token = $response->access_token;
            $this->expiry_time = time() + $response->expires_in;
            $this->save();
        } catch (Exception $e) {
            return 'Refresh Token Error ' . $e->getCode() . ':' . $e->getMessage();
        }
    }

    // @todo #marek maybe you can make this a boolean value to help with the refreshing process
    //      you can then use the right verbage for the function name too i.e. isAccessTokenExpired(): bool
    //      then the service can perform the necessary work for doing the refreshing
    public function checkAccessToken()
    {
        if ($this->expiry_time->isBefore(Carbon::now())) {
            $this->refreshAccessToken();
        }
    }

    /**
     * Send a cURL API request to go "next" or "previous" based on the variable passed.
     * @param string $nextOrPrevious
     * @return void
     */
    public function requestNavigation(string $nextOrPrevious)
    {
        $this->checkAccessToken();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $nextOrPrevious,
            'POST',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );

        $request->request();
    }

    /**
     * Send a cURL API request to "pause" or "play" based on the variable passed.
     * @param string $pauseOrPlay
     * @return void
     */
    public function requestPausePlay(string $pauseOrPlay)
    {
        $this->checkAccessToken();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $pauseOrPlay,
            'PUT',
            [
                'Authorization: Bearer ' . $this->getAccessToken(),
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );
        $request->request();
    }
    public function getCurrentPlaying()
    {
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player',
            'GET',
            [
                'Authorization: Bearer ' . $this->getAccessToken(),
                'Content-Type: application/json'
            ]
        );
        $response = $request->request();
        return $response;
    }
    public function next()
    {
        $this->requestNavigation('next');
    }

    public function previous()
    {
        $this->requestNavigation('previous');
    }

    public function resume()
    {
        $this->requestPausePlay('play');
    }

    public function pause()
    {
        $this->requestPausePlay('pause');
    }

}
