<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityIdTrait
{
    #[ORM\Column(type: 'uuid', unique: true)]
    private $uuid;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param $uuid
     *
     * @return EntityIdTrait
     */
    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }
}
