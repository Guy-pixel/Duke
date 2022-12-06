<?php

namespace App\Interfaces;

interface TokenableRecord
{
    public function getAccessToken();
    public function getRefreshToken();
    public function getExpiryTime();
}
