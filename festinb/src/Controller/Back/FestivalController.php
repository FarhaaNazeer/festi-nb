<?php

namespace App\Controller\Back;

use App\Entity\Festival;
use App\Form\FestivalType;
use App\Manager\Festival\FestivalManager;
use App\Repository\FestivalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    public const FORM_UPDATE = 'update';
    public const FORM_CREATE = 'create';

    public function __construct(
        private FestivalManager $festivalManager,
        private FestivalRepository $festivalRepository,
        private ManagerRegistry $doctrine
    ) {}

    #[Route('/festivals', name: 'festivals')]
    public function index(): Response
    {
        $festivals = $this->festivalManager->getFestivals();

        return $this->render('back/festival/index.html.twig', [
            'festivals' => $festivals,
        ]);
    }

    #[Route('/festival/create', name: 'festival_create')]
    public function create(Request $request): Response
    {
        $festival = new Festival();
        $manager = $this->doctrine->getManager();

        $form = $this->createForm(FestivalType::class, $festival);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($festival);
                $manager->flush();

                $this->redirectToRoute('app_back_festival_create');
            }
        }

        return $this->render('back/festival/create.html.twig', [
            'form' => $form->createView(),
            'type' => self::FORM_CREATE
        ]);
    }

    #[Route('/festival/update/{uuid}', name: 'festival_update')]
    public function update(Festival $festival, Request $request) : Response
    {
        $form = $this->createForm(FestivalType::class, $festival);
        $manager = $this->doctrine->getManager();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($festival);
                $manager->flush();

                $this->redirectToRoute('app_back_festival_create');
            }
        }

        return $this->render('back/festival/create.html.twig', [
            'form' => $form->createView(),
            'type' => self::FORM_UPDATE
        ]);
    }

    #[Route('/festival/delete/{uuid}', name: 'festival_delete')]
    public function delete(string $uuid): Response
    {
        $festival = current($this->festivalRepository->findBy(['uuid'=> $uuid]));
        $manager = $this->doctrine->getManager();

        $tickets = $festival->getTicket();

        foreach ($tickets as $ticket) {
            $festival->removeTicket($ticket);
        }

        $manager->remove($festival);
        $manager->flush();

        return $this->redirectToRoute('app_back_festivals');
    }
}
