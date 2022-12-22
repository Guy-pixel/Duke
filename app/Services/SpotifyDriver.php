<?php

namespace App\Services;

use App\Interfaces\SSODriver;
use App\Interfaces\TokenableRecord;
use App\Models\CurlObject;
use App\Models\SpotifyUser;
use Carbon\Carbon;
use Exception;

class SpotifyDriver implements SSODriver
{
    private string $code;

    public function __construct(string $code = ''){
        $this->code = $code;
    }
    /**
     * Requests the access token associated with the spotify user
     * @param SSODriver $tokenableRecord
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

    public function getClientID(): string
    {
        return env('SPOTIFY_CLIENT_ID');
    }

    public function getClientSecret(): string
    {
        return env('SPOTIFY_CLIENT_SECRET');
    }

    public function getAuthorizationURL(): string
    {
        return env('SPOTIFY_AUTHORIZATION_URL');
    }

    public function generateAuthorizationLink(): string
    {
        return $this->getAuthorizationURL() . CurlObject::buildPostFields(
                [
                    'response_type' => 'code',
                    'client_id' => $this->getClientID(),
                    'scope' => 'app-remote-control
                     user-top-read
                     user-read-currently-playing
                     user-read-recently-played
                     streaming app-remote-control
                     user-read-playback-state
                     user-modify-playback-state',
                    'show_dialog' => True,
                    'redirect_uri' => env('SPOTIFY_AUTHORIZATION_REDIRECT_URI')
                ]
            );
    }

    public function callbackResponse()
    {
        if (isset($_GET['code'])) {
            $this->setCode($_GET['code']);

        } else {
            echo('<script>console.log("no code returned")</script>');
        }

    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getAccessTokenURL()
    {
        return 'https://accounts.spotify.com/api/token';
    }

    public function setAccessToken(TokenableRecord $tokenableRecord, string $accessToken)
    {
        $tokenableRecord->setAccessToken($accessToken);
    }

    public function createUser()
    {

    }

    public function setRefreshToken(TokenableRecord $tokenableRecord, string $accessToken)
    {
        $tokenableRecord->setRefreshToken($accessToken);
    }

    public function getAccessToken()
    {
    }

    public function getRefreshToken()
    {
    }

    /**
     * Requests the username of the spotify user, update later to add further information.
     *
     * @return mixed
     */
    public function requestUserInfo(SpotifyUser $spotifyUser): string
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

    public function refreshAccessToken(SpotifyUser $spotifyUser): string
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

    public function getCurrentPlaying(SpotifyUser $spotifyUser): string
    {
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player',
            'GET',
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
                'Content-Type: application/json'
            ]
        );
        return $request->request();
    }

    public function combinedRequest(SpotifyUser $spotifyUser, string $nextOrPreviousOrPauseOrPlay){
        static::isAccessTokenExpired($spotifyUser);
        $requestType = '';
        if($nextOrPreviousOrPauseOrPlay != 'play' or $nextOrPreviousOrPauseOrPlay != 'pause'){
            $requestType = 'POST';
        } else {
            $requestType = 'PUT';
        }
        $request = new CurlObject(
            'https://api.spotify.com/v1/me/player/' . $nextOrPreviousOrPauseOrPlay,
            $requestType,
            [
                'Authorization: Bearer ' . $spotifyUser->getAccessToken(),
                'Content-Type: application.json',
                'Content-Length: 0'
            ]
        );


    }

    /**
     * Send a cURL API request to go "next" or "previous" based on the variable passed.
     * @param SpotifyUser $spotifyUser
     * @param string $nextOrPrevious
     * @return void
     */
    public function requestNavigation(SpotifyUser $spotifyUser, string $nextOrPrevious): void
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
     * @param SpotifyUser $spotifyUser
     * @param string $pauseOrPlay
     * @return void
     */
    public function requestPausePlay(SpotifyUser $spotifyUser, string $pauseOrPlay): void
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

    public function isAccessTokenExpired(TokenableRecord $tokenableRecord)
    {
        if ($tokenableRecord->getExpiryTime()->isBefore(Carbon::now())) {
            return false;
        } else {
            return true;
        }
    }

    public function authorizeUser(TokenableRecord $tokenableRecord)
    {
        if (!$tokenableRecord->getAccessToken()) {
            return false;
        } else {
            $request = new CurlObject('https://api.spotify.com/v1/me/'
            );
            $tokenableRecord->getAccessToken();
        }
    }
}
