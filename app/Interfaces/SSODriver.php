<?php

namespace App\Interfaces;

use App\Models;


interface SSODriver
{

    public function getClientID();
    public function getClientSecret();
    public function getAuthorizationURL();
    public function generateAuthorizationLink();
    public function setCode($code);
    public function getCode();
    public function getAccessTokenURL();
    public function setAccessToken(TokenableRecord $tokenableRecord, string $accessToken);
    public function setRefreshToken(TokenableRecord $tokenableRecord, string $refreshToken);
    public function getAccessToken();
    public function getRefreshToken();
    public function isAccessTokenExpired(TokenableRecord $tokenableRecord);


}
