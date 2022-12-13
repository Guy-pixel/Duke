<?php

namespace App\Services;

use App\Interfaces\SSODriver;
use App\Interfaces\TokenableRecord;
use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Exception;

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
        return 'https://accounts.spotify.com/api/token';
    }
    public function setAccessToken(TokenableRecord $tokenableRecord, string $accessToken)
    {
        $tokenableRecord->setAccessToken($accessToken);
    }
    public function createUser(){

    }
    public function setRefreshToken(){}

    public function getAccessToken(){}
    public function getRefreshToken(){}
    /**
     * Requests the username of the spotify user, update later to add further information.
     *
     * @return mixed
     */
    public function requestUserInfo(SpotifyUser $spotifyUser)
    {
        $requestUsername = new CurlObject(
            'https://api.spotify.com/v1/me',
            'GET',
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
                'Content-Type: application/json',
            ],
            []
        );
        $response = $requestUsername->request();
        if (!isset($response->id)) {
            dd($response);
        } else {
            $spotifyUser->setUserName($response->id);
        }
        return $response;

    }
    public function refreshAccessToken(SpotifyUser $spotifyUser)
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
                'refresh_token' => $spotifyUser->getRefreshToken()
            ]
        );
        try {
            $response = $refreshAccessToken->request();

            $spotifyUser->setAccessToken($response->access_token);
            $spotifyUser->setExpiryTime(time() + $response->expires_in);
            $spotifyUser->save();
        } catch (Exception $e) {
            return 'Refresh Token Error ' . $e->getCode() . ':' . $e->getMessage();
        }

    }
    public function getCurrentPlaying(SpotifyUser $spotifyUser)
    {
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player',
            'GET',
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
                'Content-Type: application/json'
            ]
        );
        $response = $request->request();
        return $response;
    }
    /**
     * Send a cURL API request to go "next" or "previous" based on the variable passed.
     * @param string $nextOrPrevious
     * @return void
     */
    public function requestNavigation(SpotifyUser $spotifyUser, string $nextOrPrevious)
    {
        $spotifyUser->isAccessTokenExpired();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $nextOrPrevious,
            'POST',
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
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
    public function requestPausePlay(SpotifyUser $spotifyUser, string $pauseOrPlay)
    {
        $spotifyUser->isAccessTokenExpired();
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $pauseOrPlay,
            'PUT',
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );
        $request->request();
    }
}
