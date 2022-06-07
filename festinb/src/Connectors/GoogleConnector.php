<?php

namespace App\Connectors;

use App\AbstractClasses\AuthenticatorAbstractClass;
use App\Authenticators\GoogleAuthenticator;
use App\Interfaces\AuthenticatorInterface;

class GoogleConnector extends AuthenticatorAbstractClass
{

    public function getAuthenticatorConnector(): AuthenticatorInterface
    {
        return new GoogleAuthenticator();
    }
}