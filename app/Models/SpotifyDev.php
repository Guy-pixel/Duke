<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyDev extends Model
{
    use HasFactory;
    public $client_id;
    public $client_secret;
    private $token;
    public $userToken;
    public function __construct(string $client_id, string $client_secret, $token=NULL){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
    }

    /**
     * Simple getToken request which pulls authorisation token from Spotify based on the
     * base64_encode of the client_id:client_secret
     * @return string token
     */
    public function getToken(){
        if(!isset($this->token)) {
          $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://accounts.spotify.com/api/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret),
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            $this->token=$response->access_token;
            return $this->token;
        } else {
            return $this->token;
        }
    }
    public function createAuthorizationLink(){
        $scope='app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state';
        $params=array(
          'response_type' => 'code',
          'client_id'=> $this->client_id,
          'scope' => $scope,
          'show_dialog' => True,
          'redirect_uri'=> 'http://127.0.0.1:8000/'
        );
        $str_param='';
        foreach($params as $key=>$value) {
            $str_param .= $key . '=' . urlencode($value) . '&';
        }
        return $str_param;

    }



}
