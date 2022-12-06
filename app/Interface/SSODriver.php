<?php

<<<<<<< Updated upstream:app/Interfaces/SSODriver.php
namespace App\Interfaces;

use App\Models;

=======
namespace App\Interface;
>>>>>>> Stashed changes:app/Interface/SSODriver.php

interface SSODriver
{

    public function getClientID();
    public function getClientSecret();
    public function getAuthorizationURL();
    public function generateAuthorizationLink();
    public function setCode($code);
    public function getCode();
    public function getAccessTokenURL();
    public function setAccessToken(TokenableRecord $tokenableRecord);
    public function setRefreshToken();
    public function getAccessToken();
    public function getRefreshToken();

}
