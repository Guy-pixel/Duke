<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyUser extends Model
{
    use HasFactory;
    public $client_id;
    public $client_secret;
    public $authToken;
    public function construct($client_id = NULL, $client_secret = NULL, $authToken = NULL){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
        $this->authToken=$authToken;
    }
    public function getUserToken(string $code, string $devAppID, string $devAppSecret){
        $params=array(
            'code' => $code,
            'redirect_uri'=> 'http://127.0.0.1:8000/',
            'grant_type' => 'authorization_code'
        );
        $str_param='';
        foreach($params as $key=>$value) {
            $str_param .= $key . '=' . urlencode($value) . '&';
        }
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
                CURLOPT_POSTFIELDS => $str_param,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . base64_encode($devAppID . ':' . $devAppSecret),
                    'Content-Type: application/x-www-form-urlencoded'
                )
            )
        );
        $response=json_decode(curl_exec($curl));
        curl_close($curl);
        if(isset($response->access_token)) {
            $this->authToken = $response->access_token;
        }
        return $response;
    }

}
