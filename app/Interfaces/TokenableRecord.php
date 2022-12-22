<?php

namespace App\Interfaces;
/**
 * Interface for records that require auth workflow including Access Tokens, Refresh Tokens and Expiry Times based on
 * traditional OAuth 2.0 workflow.
 */
interface TokenableRecord
{
    public function getAccessToken();
    public function getRefreshToken();
    public function getExpiryTime();

    public function setAccessToken(string $accessToken);
    public function setRefreshToken(string $refreshToken);
    public function setExpiryTime();
}
