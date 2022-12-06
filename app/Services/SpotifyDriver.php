<?php

namespace App\Services;

use App\Interfaces\SSODriver;
use App\Interfaces\TokenableRecord;
use App\Models\CurlObject;

class SpotifyDriver implements SSODriver{
    private string $code;
    /**
     * Requests the access token associated with the spotify user
     * @param string $devApp_id
     * @param string $devApp_secret
     * @param string $code
     * @return void
     */
    public function requestAccessToken(SSODriver $tokenableRecord)
    {

        $requestAccess = new CurlObject(
            $tokenableRecord->getAccessTokenURL(),
            'POST',
            [
                'Authorization: Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID') . ':' . env('SPOTIFY_CLIENT_SECRET')),
                'Content-Type:application/x-www-form-urlencoded'
            ],
            [
                'grant_type' => 'authorization_code',
                'code' => $this->getCode(),
                'redirect_uri' => env('SPOTIFY_AUTHORIZATION_REDIRECT_URI')
            ]
        );
        return $requestAccess->request();

    }
    public function getClientID(){
        return env('SPOTIFY_CLIENT_ID');
    }
    public function getClientSecret(){
        return env('SPOTIFY_CLIENT_SECRET');
    }
    public function getAuthorizationURL(){
        return env('SPOTIFY_AUTHORIZATION_URL');
    }
    public function generateAuthorizationLink(){
        return $this->getAuthorizationURL() . CurlObject::buildPostFields(
                [
                    'response_type' => 'code',
                    'client_id' => $this->getClientID(),
                    'scope' => 'app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state',
                    'show_dialog' => True,
                    'redirect_uri' => env('SPOTIFY_AUTHORIZATION_REDIRECT_URI')
                ]
            );
    }
    public function callbackResponse(){
        if(isset($_GET['code'])){
            $this->setCode($_GET['code']);

        } else {
            echo('<script>console.log("no code returned")</script>');
        }

    }
    public function setCode($code): void
    {
        $this->code=$code;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function getAccessTokenURL(){
    }
    public function setAccessToken(TokenableRecord $tokenableRecord)
    {

    }
    public function createUser(){

    }
    public function setRefreshToken(){}

    public function getAccessToken(){}
    public function getRefreshToken(){}
}
