<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    #[Route('/festivals', name: 'app_front_festivals')]
    public function index(): Response
    {


        return $this->render('front/festival/index.html.twig', [
        ]);
    }

}
