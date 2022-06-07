<?php

namespace App\AbstractClasses;

use App\Interfaces\AuthenticatorInterface;

abstract class AuthenticatorAbstractClass
{
    abstract public function getAuthenticatorConnector() : AuthenticatorInterface;

    public function connect() : void
    {
        $connector = $this->getAuthenticatorConnector();

        $connector->callServer();
        $connector->getAccessToken();
        $connector->getAuthorizationCode();
        $connector->getUserInfo();
    }

}