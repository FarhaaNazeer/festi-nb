<?php

namespace App\Authenticators;

use App\Interfaces\AuthenticatorInterface;

class GoogleAuthenticator implements AuthenticatorInterface
{
//    private $client_id;
//    private $client_secret;
//    private $redirect_uri;
//    private $scope;
//    private $access_type;
//    private $response_type;

    public function __construct(
       private $client_id,
       private $client_secret,
       private $redirect_uri,
       private $scope,
       private $access_type,
       private $response_type
    ) {}

    public function callServer()
    {}

    public function getAuthorizationCode()
    {}

    public function getAccessToken()
    {}

    public function getUserInfo()
    {}

}