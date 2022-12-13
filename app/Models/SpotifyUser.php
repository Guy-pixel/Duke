<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class SpotifyUser extends Model
{
    use HasFactory;


    protected $fillable = [
        'username',
        'access_token',
        'refresh_token',
        'expiry_time'
    ];
    protected $dates = [
        'expiry_time',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [

    ];
    protected $table='spotify_users';

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Returns the expiry_time of the object which
     * @return int|mixed
     */
    public function getExpiryTime()
    {
        return $this->expiry_time;
    }

    /**
     * Returns the username of the object
     * @return mixed|string
     */
    public function getUsername()
    {

        return $this->username;

    }
    public function isAccessTokenExpired()
    {
        if ($this->expiry_time->isBefore(Carbon::now())) {
            $this->refreshAccessToken();
        }
    }





    public function next()
    {
        $this->requestNavigation('next');
    }

    public function previous()
    {
        $this->requestNavigation('previous');
    }

    public function resume()
    {
        $this->requestPausePlay('play');
    }

    public function pause()
    {
        $this->requestPausePlay('pause');
    }

}
