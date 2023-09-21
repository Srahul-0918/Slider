<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 244)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?float $Size = null;

    #[ORM\Column(length: 233)]
    private ?string $Path = null;

    #[ORM\Column(length: 244)]
    private ?string $SiteReference = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->Size;
    }

    public function setSize(float $Size): static
    {
        $this->Size = $Size;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): static
    {
        $this->Path = $Path;

        return $this;
    }

    public function getSiteReference(): ?string
    {
        return $this->SiteReference;
    }

    public function setSiteReference(string $SiteReference): static
    {
        $this->SiteReference = $SiteReference;

        return $this;
    }
}
