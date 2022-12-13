<?php

namespace App\Interfaces;

interface TokenableRecord
{
    public function getAccessToken();
    public function getRefreshToken();
    public function getExpiryTime();

    public function setAccessToken(string $accessToken);
    public function setRefreshToken(string $refreshToken);
    public function setExpiryTime();
}
