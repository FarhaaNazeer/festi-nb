<?php

namespace App\Dto\Festival;

use App\Dto\Ticket\TicketDto;
use Symfony\Component\Serializer\Annotation\Groups;

class FestivalDto
{
    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $uuid = null;

    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $name = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['festival_all'])]
    public ?\DateTimeInterface $begin_at = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['festival_all'])]
    public ?\DateTimeInterface $end_at = null;

    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $slug = null;

    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $short_description = null;

    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $description = null;


    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $city = null;

    /**
     * @var string|null
     */
    #[Groups(['festival_all'])]
    public ?string $country = null;

    /**
     * @var string|null
     */
    public ?string $image = null;

    /**
     * @var TicketDto|null
     */
    #[Groups(['festival_all'])]
    public $tickets = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['festival_all'])]
    public ?\DateTimeInterface $created_at = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[Groups(['festival_all'])]
    public ?\DateTimeInterface $updated_at = null;


}