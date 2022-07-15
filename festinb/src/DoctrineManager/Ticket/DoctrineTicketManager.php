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
        dd($this->ticketRepository->findOneBy(['uuid' => '5abe9dae-f26d-49eb-bea2-112a95af63be']));
        return current($this->ticketRepository->findBy(['uuid' => $uuid]));
    }
}