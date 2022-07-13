<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'client_area')]
    public function index(): Response
    {
        return $this->render('front/client_area/client_area.html.twig', [
        ]);
    }
}
