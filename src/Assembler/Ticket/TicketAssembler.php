<?php

namespace App\Assembler\Ticket;

use App\Assembler\AbstractAssembler;
use App\Dto\Ticket\TicketDto;
use App\Entity\Festival;
use App\Entity\Ticket;

class TicketAssembler extends AbstractAssembler
{
    public function __construct(
    ) {}


    public function transform(Ticket $ticket) : TicketDto
    {
        if (!$ticket instanceof Ticket) {
            throw new \TypeError(sprintf('Argument 1 passed to %s() must be an instance of %s, %s given.', __METHOD__, Festival::class, get_debug_type($ticket)));
        }
        $ticketDto                = new TicketDto();
        $ticketDto->uuid          = $ticket->getUuid();
        $ticketDto->title         = $ticket->getTitle();
        $ticketDto->startDate     = $ticket->getStartDate();
        $ticketDto->endDate       = $ticket->getEndDate();
        $ticketDto->price         = $ticket->getPrice();
        $ticketDto->description   = $ticket->getDescription();
        $ticketDto->isExpired     = $ticket->getIsExpired();

        return $ticketDto;
    }

    public function reverseTransform(TicketDto $ticketDto, Ticket $ticket = null) : Ticket
    {
        if (!$ticketDto instanceof TicketDto) {
            throw new \TypeError(sprintf("Argument 1 passed to %s() must be an instance of %s, %s given", __METHOD__, TicketDto::class, get_debug_type($ticketDto)));
        }
        $ticket ??= new Ticket();

        $ticket->setTitle($ticketDto->title);
        $ticket->setStartDate($ticketDto->startDate);
        $ticket->setEndDate($ticketDto->endDate);
        $ticket->setPrice($ticketDto->price);
        $ticket->setDescription($ticketDto->description);
        $ticket->setIsExpired($ticketDto->isExpired ?? false);

        return $ticket;
    }
}