<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class SpotifyUser extends Model
{
    use HasFactory;

    private int $id;
    private string $username;
    private string $access_token;
    private string $refresh_token;
    private int $expiry_time;

    protected $fillable = [
        'username',
        'access_token',
        'refresh_token',
        'expiry_time'
    ];
    protected $hidden = [

    ];
    protected $table='spotify_users';
    public function __construct($username = '', $access_token = '', $refresh_token = '', $expiry_time = 0)
    {
        $this->username = $username;
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->expiry_time = $expiry_time;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function getExpiryTime()
    {
        return $this->expiry_time;
    }

    public function getUsername()
    {

        return $this->username;

    }

    /**
     * Request the access token for the user and set it to the current instance
     * @param string devApp Id
     * @param string devApp Secret
     * @param string devApp Token
     */
    public function requestAccessToken(string $devApp_id, string $devApp_secret, string $code)
    {
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
        } catch (Exception $e) {
            return 'Refresh Token Error ' . $e->getCode() . ':' . $e->getMessage();
        }
    }

    public function checkAccessToken()
    {
        if ($this->expiry_time < time()) {
            $this->refreshAccessToken();
        }
    }

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

    public function requestPausePlay(string $pauseOrPlay)
    {
        $this->checkAccessToken();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $pauseOrPlay,
            'PUT',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );
        dd($request->request());
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
