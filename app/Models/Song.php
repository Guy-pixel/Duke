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
        'release_date'
    ];

    protected function getName()
    {
        return $this->name;
    }
    protected function getAlbum()
    {
        return $this->album;
    }
    protected function getArtist()
    {
        return $this->artist;
    }
    protected function getReleaseDate()
    {
        return $this->release_date;
    }
    protected function setName(string $name)
    {
        return $this->name=$name;
    }
    protected function setAlbum(string $album)
    {
        return $this->album=$album;
    }
    protected function setArtist(string $artist)
    {
        return $this->artist=$artist;
    }
    protected function setReleaseDate($releaseDate)
    {
        return $this->release_date=$releaseDate;
    }


}
