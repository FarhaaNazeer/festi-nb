<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    use EntityIdTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['ticket_all'])]
    private $title;

    #[ORM\Column(type: 'date')]
    #[Groups(['ticket_all'])]
    private $start_date;

    #[ORM\Column(type: 'date')]
    #[Groups(['ticket_all'])]
    private $end_date;

    #[ORM\Column(type: 'float')]
    #[Groups(['ticket_all'])]
    private $price;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['ticket_all'])]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $artists;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'ticket')]
    private $festival;

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => false] )]
    #[Groups(['ticket_all'])]
    private $is_expired;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: CartItem::class)]
    private $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }


    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArtists(): ?string
    {
        return $this->artists;
    }

    public function setArtists(?string $artists): self
    {
        $this->artists = $artists;

        return $this;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): self
    {
        $this->festival = $festival;

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

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setTicket($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getTicket() === $this) {
                $cartItem->setTicket(null);
            }
        }

        return $this;
    }
}
