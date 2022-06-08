<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    #[Route(path: '/google/connect', name: 'app_google_connect')]
    public function googleConnect(ClientRegistry $clientRegistry) : RedirectResponse
    {
        return $clientRegistry->getClient('google')->redirect([], []);
    }

    #[Route(path: 'check/google/connect', name: 'app_check_google_connect')]
    public function checkGoogleConnect(Request $request)
    {
//        dd($request);
    }
}
