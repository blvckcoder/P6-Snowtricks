<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\IdentifiableTrait;
use App\Repository\MediaRepository;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\Table(name: "media")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["image" => Image::class, "video" => Video::class])]
abstract class Media
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
