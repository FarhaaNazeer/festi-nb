<?php

namespace App\Assembler\Festival;

use App\Assembler\AbstractAssembler;
use App\Assembler\Ticket\TicketAssembler;
use App\Dto\Festival\FestivalDto;
use App\Entity\Festival;

class FestivalAssembler extends AbstractAssembler
{
    public function __construct (
        private TicketAssembler $ticketAssembler,
    ) {}

    public function transform(Festival $festival) : FestivalDto
    {
        if (!$festival instanceof Festival) {
            throw new \TypeError(sprintf('Argument 1 passed to %s() must be an instance of %s, %s given.', __METHOD__, Festival::class, get_debug_type($festival)));
        }

            $festivalDto                        = new FestivalDto();
            $festivalDto->uuid                  = $festival->getUuid();
            $festivalDto->name                  = $festival->getName();
            $festivalDto->slug                  = $festival->getSlug();
            $festivalDto->begin_at              = $festival->getBeginAt();
            $festivalDto->end_at                = $festival->getEndAt();
            $festivalDto->short_description     = $festival->getShortDescription();
            $festivalDto->description           = $festival->getDescription();
            $festivalDto->city                  = $festival->getCity();
            $festivalDto->country               = $festival->getCountry();
            $festivalDto->image                 = $festival->getImageFile();
            $festivalDto->tickets               = $this->ticketAssembler->transformArray($festival->getTicket());

            return $festivalDto;
        }

    public function reverseTransform() : Festival
    {}
}