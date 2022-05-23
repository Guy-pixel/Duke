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
    public function getAuthToken(string $client_id, string $client_secret, string $code){
        $requestAuth = new CurlObject(
            'https://accounts.spotify.com/api/token',
            'POST',
            [
                'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
                'Content-Type:application/x-www-form-urlencoded'
            ],
            [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => 'http://127.0.0.1:8000/'
            ]
        );
        $requestAuth->request();
    }
    public function refreshAuthToken(){

    }
    public function checkAuthToken(){

    }
}
