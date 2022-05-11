<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\NoReturn;

class SpotifyUser extends Model
{
    use HasFactory;
    public string $client_id;
    public string $client_secret;
    public string $accessToken;
    public function __construct($client_id = '', $client_secret = ''){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
    }
    public function getUserToken(string $code, string $devAppID, string $devAppSecret){
        $userToken = new CurlObject(
            'https://accounts.spotify.com/api/token',
            'POST',
            [
                'Authorization: Basic ' . base64_encode($devAppID . ':' . $devAppSecret),
                'Content-Type: application/x-www-form-urlencoded'],
            [
                'code' => $code,
                'redirect_uri'=> 'http://127.0.0.1:8000/',
                'grant_type' => 'authorization_code'
            ]
        );
        $response = $userToken->request();
        if(isset($response->access_token)) {
            $this->accessToken = $response->access_token;
        }
        return $response;

    }
    public function getDevices(){
        $getDevices = new CurlObject(
            'https://api.spotify.com/v1/me/player/devices',
            'GET',
            [
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: application/json'
            ]
        );

        return $getDevices->request();
    }
    public function skipToNext(){
        $skipRequest= new CurlObject(
            'https://api.spotify.com/v1/me/player/next',
            'POST',
            [
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: application/json',
                'Content-Length: 0'
            ]
        );
        $skipRequest->Request();
    }

}
