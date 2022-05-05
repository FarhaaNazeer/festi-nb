<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    use EntityIdTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'boolean')]
    private $is_expired;

    #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: 'tickets')]
    private $reservation;

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsExpired(): ?bool
    {
        return $this->is_expired;
    }

    public function setIsExpired(bool $is_expired): self
    {
        $this->is_expired = $is_expired;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
