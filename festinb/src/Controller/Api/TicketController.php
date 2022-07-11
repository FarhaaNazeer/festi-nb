<?php

namespace App\Controller\Api;

use App\Assembler\Festival\FestivalAssembler;
use App\Assembler\Ticket\TicketAssembler;
use App\Dto\Ticket\TicketDto;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class TicketController extends AbstractController
{
    public function __construct(
        private TicketRepository $repository,
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private TicketAssembler $ticketAssembler,
        private FestivalAssembler $festivalAssembler
    )
    {}

    #[Route('/tickets', name: 'tickets', methods: ['GET'])]
    public function getTickets(): JsonResponse
    {
        $tickets = $this->serializer->serialize(
                    $this->repository->findAll(),
             JsonEncoder::FORMAT
        );

        return new JsonResponse([
            $tickets,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;charset=UTF-8'],
            true
        ]);
    }

    #[Route('/tickets', name: 'createTickets', methods: ['POST'])]
    public function createTicket(Request $request): JsonResponse
    {
        $ticketDto = $this->serializer->deserialize($request->getContent(), TicketDto::class, 'json');

        $ticket = $this->ticketAssembler->reverseTransform($ticketDto);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return new JsonResponse([
            $this->serializer->serialize(
                $this->ticketAssembler->transform($ticket),
                'json'
            ),
            Response::HTTP_CREATED,
            ['Content-Type' => 'application/json'],
            true
        ]);
    }
}