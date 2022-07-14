<?php

namespace App\Controller\Back;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Manager\Ticket\TicketManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends  AbstractController
{

    public function __construct(private TicketManager $manager)
    {}

    #[Route('/tickets', name: 'app_tickets')]
    public function get(): Response
    {
        $tickets = $this->manager->get();

        return $this->render('back/ticket/login.html.twig', [
            'tickets' => $tickets
        ]);
    }

    #[Route('/ticket/create', name: 'ticket_create')]
    public function create(Request $request): Response
    {
        $festival = new Ticket();

        $form = $this->createForm(TicketType::class, $festival);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $responseStatusCode = $this->manager->post($form->getData());

                if (!Response::HTTP_OK === $responseStatusCode) {
                    throw new \Exception('Une erreur est survenue', $responseStatusCode);
                }

                $this->redirectToRoute('app_back_ticket_create');
            }
        }

        return $this->render('back/ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}