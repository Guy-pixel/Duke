<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyConnect extends Model
{
    use HasFactory;
    public $client_id;
    public $client_secret;
    public function __construct($client_id, $client_secret){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
    }
    /*
     * SpotifyConnect model for creating connection between database and the SpotifyAPI.
     * Steps:
     * 1. Create SpotifyApp
     * 2. Generate client Id and client Secret.
     * 3. Push header with grant type.
     * 4. Push client Id and client Secret.
     * 5. client created
     */
    public function getToken(){
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
                'Authorization: Basic ' . base64_encode($this->client_id) . ':' . base64_encode($this->client_secret),
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        print('client id:' . base64_encode($this->client_id) . '<br/>client secret:' . base64_encode($this->client_secret) . '<br/>');
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}
