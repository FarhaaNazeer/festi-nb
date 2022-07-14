<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/partners', name: 'partners')]
    public function index(): Response
    {
        return $this->render('front/partners/index.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }
}
