<?php

namespace App\Entity;

use App\Repository\FestivalRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use App\Traits\VichImageTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FestivalRepository::class)]
#[Vich\Uploadable]
class Festival
{
    use EntityIdTrait;
    use VichImageTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['festival_all'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Groups(['festival_all'])]
    private $slug;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['festival_all'])]
    private $begin_at;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['festival_all'])]
    private $end_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['festival_all'])]
    private $short_description;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['festival_all'])]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['festival_all'])]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['festival_all'])]
    private $country;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Ticket::class)]
    #[Groups(['festival_all'])]
    private $ticket;

    public function __construct()
    {
        $this->ticket = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->begin_at;
    }

    public function setBeginAt(\DateTimeInterface $begin_at): self
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTimeInterface $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->short_description = $short_description;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket[] = $ticket;
            $ticket->setFestival($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->ticket->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getFestival() === $this) {
                $ticket->setFestival(null);
            }
        }

        return $this;
    }
}
