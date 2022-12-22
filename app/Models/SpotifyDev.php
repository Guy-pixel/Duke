<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SpotifyDev extends Model implements TokenableRecord
{
    use HasFactory;

    public string $client_id;
    public string $client_secret;
    private string $token;

    public function __construct(string $client_id, string $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * Simple getAccessToken request which pulls authorisation token from Spotify based on the
     * base64_encode of the client_id:client_secret
     * @return string Token
     */
    public function getAccessToken()
    {
        if (!isset($this->token)) {
            $getToken = new CurlObject(
                'https://accounts.spotify.com/api/token',
                'POST',
                [
                    'Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret),
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                [
                    'grant_type' => 'client_credentials'
                ]
            );
            if(isset($getToken->request()->access_token)) {
                return $this->token = $getToken->request()->access_token;
            } else {
                return $getToken->request();
            }
        } else {
            return $this->token;
        }
    }

    /**
     * Request the access token for the user and set it to the current instance
     *
     */


    public function createAuthorizationLink(): string
    {
        // @todo #marek same as above. Why is this model caring about building an array for a curl request?
        //      Your Song model is a good example. Just parameters to reference for the business logic.
        return env('SPOTIFY_AUTHORIZATION_URL') . CurlObject::buildPostFields(
            [
                'response_type' => 'code',
                'client_id' => $this->client_id,
                'scope' => 'app-remote-control
                user-top-read
                user-read-currently-playing
                user-read-recently-played
                streaming
                app-remote-control
                user-read-playback-state
                user-modify-playback-state',
                'show_dialog' => True,
                'redirect_uri' => env('SPOTIFY_AUTHORIZATION_REDIRECT_URI')
            ]
        );
    }


}
