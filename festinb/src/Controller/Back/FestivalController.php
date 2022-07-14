<?php

namespace App\Controller\Back;

use App\Entity\Festival;
use App\Form\FestivalType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    #[Route('/festival', name: 'festival')]
    public function index(): Response
    {
        return $this->render('festival/index.html.twig', [
            'controller_name' => 'FestivalController',
        ]);
    }

    #[Route('/festival/create', name: 'festival_create')]
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

                $this->redirectToRoute('festival_add');
            }
        }

        return $this->render('back/festival/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
