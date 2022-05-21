<?php

namespace App\Entity;

use App\Repository\FestivalRepository;
use App\Traits\EntityIdTrait;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FestivalRepository::class)]
class Festival
{
    use EntityIdTrait;
    use TimestampTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    #[ORM\Column(type: 'datetime')]
    private $begin_at;

    #[ORM\Column(type: 'datetime')]
    private $end_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $short_description;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'festivals')]
    private $client;

    #[ORM\OneToMany(mappedBy: 'festival', targetEntity: Pass::class)]
    private $passes;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->passes = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(User $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
        }

        return $this;
    }

    public function removeClient(User $client): self
    {
        $this->client->removeElement($client);

        return $this;
    }

    /**
     * @return Collection<int, Pass>
     */
    public function getPasses(): Collection
    {
        return $this->passes;
    }

    public function addPass(Pass $pass): self
    {
        if (!$this->passes->contains($pass)) {
            $this->passes[] = $pass;
            $pass->setFestival($this);
        }

        return $this;
    }

    public function removePass(Pass $pass): self
    {
        if ($this->passes->removeElement($pass)) {
            // set the owning side to null (unless already changed)
            if ($pass->getFestival() === $this) {
                $pass->setFestival(null);
            }
        }

        return $this;
    }
}
