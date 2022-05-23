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
    public function getAuthToken(string $client_id, string $code){
        $request= new CurlObject(
            [
                
            ]
        );
    }
    public function refreshAuthToken(){

    }
    public function checkAuthToken(){

    }
}
