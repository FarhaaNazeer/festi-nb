<?php

namespace App\Entity;

use App\Repository\PassRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassRepository::class)]
class Pass
{
    use EntityIdTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $short_description;

    #[ORM\ManyToOne(targetEntity: Festival::class, inversedBy: 'passes')]
    private $festival;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

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
}
