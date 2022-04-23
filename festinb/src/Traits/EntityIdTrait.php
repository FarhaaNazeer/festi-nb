<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

trait EntityIdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Uuid]
    #[ORM\CustomIdGenerator(class:UuidV4::class)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\Column(type: 'uuid', unique: true)]
    private $uuid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}