<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SpotifyDev extends Model
{
    use HasFactory;

    public string $client_id;
    public string $client_secret;
    private string $token;
    public string $userToken;

    public function __construct(string $client_id, string $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * Simple getToken request which pulls authorisation token from Spotify based on the
     * base64_encode of the client_id:client_secret
     * @return string Token
     */
    public function getToken()
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

    public function createAuthorizationLink(): string
    {
        return CurlObject::buildPostFields(
            [
                'response_type' => 'code',
                'client_id' => $this->client_id,
                'scope' => 'app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state',
                'show_dialog' => True,
                'redirect_uri' => 'http://127.0.0.1:8000/'
            ]
        );
    }


}
