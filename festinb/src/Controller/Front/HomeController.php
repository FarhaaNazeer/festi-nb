<?php

namespace App\Controller\Front;

use App\Form\SearchBarFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $formSearch = $this->createForm(SearchBarFormType::class);

        return $this->render('home/index.html.twig', [
            'formSearch' => $formSearch->createView()
        ]);
    }
}
