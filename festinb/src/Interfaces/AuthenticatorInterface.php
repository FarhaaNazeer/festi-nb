<?php

namespace App\Interfaces;

interface AuthenticatorInterface
{
    public function callServer();

    public function getAuthorizationCode();

    public function getAccessToken();

    public function getUserInfo();
}