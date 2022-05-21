<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Form\FestivalType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    #[Route('/festival', name: 'app_festival')]
    public function index(): Response
    {
        return $this->render('festival/index.html.twig', [
            'controller_name' => 'FestivalController',
        ]);
    }

    #[Route('/festival/add', name: 'app_festival_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $festival = new Festival();
        $manager = $doctrine->getManager();

        $form = $this->createForm(FestivalType::class, $festival);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
               $manager->persist($festival);
               $manager->flush();

               $this->redirectToRoute('app_festival_add');
            }
        }

        return $this->render('festival/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
