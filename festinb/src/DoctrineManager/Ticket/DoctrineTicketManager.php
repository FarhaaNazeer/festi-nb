<?php

namespace App\DoctrineManager\Ticket;

use App\Entity\Ticket;
use App\Repository\TicketRepository;

class DoctrineTicketManager
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {}

    public function getTicket(string $uuid): Ticket
    {
        return current($this->ticketRepository->findBy(['uuid' => $uuid]));
    }
}