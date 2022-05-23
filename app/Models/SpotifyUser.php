<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class SpotifyUser extends Model
{
    use HasFactory;

    private string $username;
    private string $client_id;
    private string $client_secret;
    private string $access_token;
    private string $refresh_token;
    private int $expiry_time;

    public function __construct($client_id = '', $client_secret = '')
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }
    public static function returnAll(){
        DB::select('select * from spotifyusers');
    }
    public function checkToken()
    {
        if (!isset($this->access_token)) {
            return "404: No Access Token Found";
        } elseif (!isset($this->refresh_token)) {
            return "404: Access Token Found, No Refresh Token Found";
        } elseif ($this->expiry_time < 3500) {
            $this->refreshToken();

        } else {

        }
    }

    public function getUserToken(string $code, string $devAppID, string $devAppSecret)
    {

        $userToken = new CurlObject(
            'https://accounts.spotify.com/api/token',
            'POST',
            [
                'Authorization: Basic ' . base64_encode($devAppID . ':' . $devAppSecret),
                'Content-Type: application/x-www-form-urlencoded'],
            [
                'code' => $code,
                'redirect_uri' => 'http://127.0.0.1:8000/',
                'grant_type' => 'authorization_code',
            ]);
        $response = $userToken->request();

        /* Create a request which will automatically refresh using a refresh token
         *  This may require full redesign so that we can ensure that we're using efficient code.
         *
         * */


        if (isset($response->access_token)) {
            $this->access_token = $response->access_token;
        }
        if (isset($response->refresh_token)) {
            $this->refresh_token = $response->refresh_token;
            $this->expiry_time = time() + $response->expires_in;
        }
        return $response;

    }

    public function getDevices()
    {
        $getDevices = new CurlObject(
            'https://api.spotify.com/v1/me/player/devices',
            'GET',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json'
            ]
        );

        return $getDevices->request();
    }

    public function skipToNext()
    {
        $skipRequest = new CurlObject(
            'https://api.spotify.com/v1/me/player/next',
            'POST',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json',
                'Content-Length: 0'
            ]
        );
        $skipRequest->Request();
    }

    public function skipToPrevious()
    {
        $skipRequest = new CurlObject(
            'https://api.spotify.com/v1/me/player/previous',
            'POST',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json',
                'Content-Length: 0'
            ]
        );
        $skipRequest->Request();
    }

    public function resume()
    {
        $skipRequest = new CurlObject(
            'https://api.spotify.com/v1/me/player/play',
            'PUT',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json',
                'Content-Length: 0'
            ]
        );
        $skipRequest->Request();
    }

    public function pause()
    {
        $skipRequest = new CurlObject(
            'https://api.spotify.com/v1/me/player/pause',
            'PUT',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json',
                'Content-Length: 0'
            ]
        );
        $skipRequest->Request();
    }

    public function saveToDB()
    {
        DB::insert('insert into spotifyusers ()');
    }
}
