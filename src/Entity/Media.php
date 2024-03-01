<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\IdentifiableTrait;
use App\Repository\MediaRepository;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    use IdentifiableTrait;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }
}
