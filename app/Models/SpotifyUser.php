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

    private string $access_token;
    private string $refresh_token;
    private int $expiry_time;

    public function __construct($access_token = '', $refresh_token = '', $expiry_time = 0)
    {
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->expiry_time = $expiry_time;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function getExpiresIn()
    {
        return $this->expiry_time;
    }

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
                'redirect_uri' => 'http://127.0.0.1:8000/'
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

    public function requestNavigation(String $navigationType)
    {
        $this->checkAccessToken();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $navigationType,
            'POST',
            [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );
        dd($request->request());
    }
    public function next(){
        $this->requestNavigation('next');
    }
    public function previous(){
        $this->requestNavigation('previous');
    }
    public function resume(){
        $this->requestNavigation('play');
    }
    public function pause(){
        $this->requestNavigation('pause');
    }

}
