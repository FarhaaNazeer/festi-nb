<?php

namespace App\Dto\Ticket;

use App\Dto\Festival\FestivalDto;
use Symfony\Component\Serializer\Annotation\Groups;

class TicketDto
{
    /**
     * @var string|null
     */
    #[Groups(['ticket_all'])]
    public ?string $uuid = null;

    /**
     * @var string|null
     */
    #[Groups(['ticket_all'])]
    public ?string $title = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['ticket_all'])]
    public ?\DateTimeInterface $startDate = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['ticket_all'])]
    public ?\DateTimeInterface $endDate = null;

    /**
     * @var float|null
     */
    #[Groups(['ticket_all'])]
    public ?float $price = null;

    /**
     * @var float|null
     */
    #[Groups(['ticket_all'])]
    public ?float $quantity = null;

    /**
     * @var string|null
     */
    #[Groups(['ticket_all'])]
    public ?string $description = null;

    /**
     * @var FestivalDto|null
     */
    public $festival = null;

    /**
     * @var bool|null
     */
    #[Groups(['ticket_all'])]
    public ?bool $isExpired = null;

}