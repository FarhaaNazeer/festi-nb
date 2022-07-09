<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    use EntityIdTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'float')]
    private $amount;

    #[ORM\Column(type: 'string', length: 255)]
    private $payment_method;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    private $userReservation;

//    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Ticket::class)]
//    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getUserReservation(): ?User
    {
        return $this->userReservation;
    }

    public function setUserReservation(?User $userReservation): self
    {
        $this->userReservation = $userReservation;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setReservation($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getReservation() === $this) {
                $ticket->setReservation(null);
            }
        }

        return $this;
    }
}
