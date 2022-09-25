<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $spotify_user_id;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'spotify_user_id'
    ];

    /**
     * Returns the spotify_user_id.
     *
     * @return int
     */
    public function getSpotifyUserId(){
        return $this->spotify_user_id;
    }

    /**
     *
     * Set the value of the property spotify_user_id.
     *
     * @param int $id
     * @return void
     */

    public function setSpotifyUserId(int $id): void
    {
        $this->spotify_user_id = $id;
    }

    /**
     * Hashes the password and returns the hash.
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
