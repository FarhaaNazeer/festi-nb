<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/partner_front', name: 'partner')]
    public function index(): Response
    {
        return $this->render('front/partners/_partners_front.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }
}
