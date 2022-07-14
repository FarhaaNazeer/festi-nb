<?php

namespace App\Controller\Back;

use App\Assembler\Festival\FestivalAssembler;
use App\Assembler\Ticket\TicketAssembler;
use App\Dto\Ticket\TicketDto;
use App\Entity\Ticket;
use App\Form\TicketType;
use App\Manager\Ticket\TicketManager;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends  AbstractController
{

    public function __construct(
        private TicketManager $manager,
        private TicketRepository $ticketRepository,
        private EntityManagerInterface $entityManager,
        private TicketAssembler $assembler,
        private FestivalAssembler $festivalAssembler
    ) {}

    #[Route('/tickets', name: 'tickets')]
    public function get(): Response
    {
        $tickets = $this->ticketRepository->findAll();

        return $this->render('back/ticket/index.html.twig', [
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

                $data = $form->getData();

                $ticketDto = new TicketDto();
                $ticketDto->title = $data->getTitle();
                $ticketDto->price = $data->getPrice();
                $ticketDto->description = $data->getDescription();
                $ticketDto->festival =  $this->festivalAssembler->transform($data->getFestival());
                $ticketDto->startDate = $data->getStartDate();
                $ticketDto->endDate =  $data->getEndDate();

                $ticket = $this->assembler->reverseTransform($ticketDto);

                $this->entityManager->persist($ticket);
                $this->entityManager->flush();

                $this->addFlash('success', 'Le ticket a été créé avec succès');
                $this->redirectToRoute('app_back_ticket_create');
            }
        }

        return $this->render('back/ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ticket/update/{uuid}', name: 'ticket_update')]
    public function update(Ticket $ticket, Request $request): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $this->entityManager->persist($ticket);
                $this->entityManager->flush();

                $this->addFlash('success', 'Le ticket a été créé avec succès');
                $this->redirectToRoute('app_back_tickets');
            }
        }

        return $this->render('back/ticket/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ticket/delete/{uuid}', name: 'ticket_delete')]
    public function delete(Ticket $ticket): Response
    {

        if ($cartItems = $ticket->getCartItems()) {
            foreach ($cartItems as $cartItem) {
                $ticket->removeCartItem($cartItem);
            }
        }

        $this->entityManager->remove($ticket);
        $this->entityManager->flush();

        $this->addFlash('danger', 'Votre billet a bien été supprimé');
       return $this->redirectToRoute('app_back_tickets');
    }
}