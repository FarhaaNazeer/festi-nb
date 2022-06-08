<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/auth', name: 'app_auth_')]
class AuthController extends AbstractController
{
    #[Route('/auth/google', name: 'app_auth_google', options: ['expose'=> true])]
    public function index(Request $request) : ?Response
    {
        $payload = json_decode($request->getContent(), true);
        $client_id  = $payload['client_id'];
        $credential = $payload['credential'];

        $client = new \Google_Client(['client_id' => $client_id]);

        if (null !== $credential) {
            $verifyIdToken = $client->verifyIdToken($credential);
            if ($verifyIdToken) {
                return new Response(
                    json_encode($verifyIdToken),
                    Response::HTTP_OK
                );
            }
        }

        return null;
    }
}
