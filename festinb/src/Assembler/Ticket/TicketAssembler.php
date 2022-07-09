<?php

namespace App\Assembler\Ticket;

use App\AbstractClass\AbstractAssembler;
use App\Dto\Ticket\TicketDto;
use App\Entity\Ticket;
use App\Interface\AssemblerInterface;

class TicketAssembler
{
    public function transform()
    {
        // TODO: Implement transform() method.
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
        $ticket->setArtists($ticketDto->artists);
//        $ticket->setFestival($ticketDto->festival);
        $ticket->setIsExpired($ticketDto->isExpired ?? false);

        return $ticket;
    }
}