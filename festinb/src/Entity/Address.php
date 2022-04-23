<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use App\Traits\AddressTrait;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    use EntityIdTrait;
    use AddressTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'address')]
    private $userAddress;

    public function getUserAddress(): ?User
    {
        return $this->userAddress;
    }

    public function setUserAddress(?User $userAddress): self
    {
        $this->userAddress = $userAddress;

        return $this;
    }
}
