<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'album',
        'artist',
        'release_date',
        'uri'
    ];

    public function getName()
    {
        return $this->name;
    }
    public function getAlbum()
    {
        return $this->album;
    }
    public function getArtist()
    {
        return $this->artist;
    }
    public function getReleaseDate()
    {
        return $this->release_date;
    }
    public function setName(string $name)
    {
        return $this->name=$name;
    }
    public function setAlbum(string $album)
    {
        return $this->album=$album;
    }
    public function setArtist(string $artist)
    {
        return $this->artist=$artist;
    }
    public function setReleaseDate($releaseDate)
    {
        return $this->release_date=$releaseDate;
    }


}
