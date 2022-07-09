<?php

namespace App\Dto\Ticket;

class TicketDto
{
    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * @var string|null
     */
    public ?string $uuid = null;

    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $startDate = null;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $endDate = null;

    /**
     * @var float|null
     */
    public ?float $price = null;

    /**
     * @var string|null
     */
    public ?string $description = null;


    public $artists;

    public $festival;

    public ?bool $isExpired = null;
}