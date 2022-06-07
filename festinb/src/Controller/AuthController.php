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
    public function index(Request $request): Response
    {
        dd($request);
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
