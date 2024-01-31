<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'packs')]
    private ?Character $persona = null;

    #[ORM\ManyToOne(inversedBy: 'packs')]
    private ?Background $background = null;

    #[ORM\ManyToOne(inversedBy: 'packs')]
    private ?Effect $effect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersona(): ?Character
    {
        return $this->persona;
    }

    public function setPersona(?Character $persona): static
    {
        $this->persona = $persona;

        return $this;
    }

    public function getBackground(): ?Background
    {
        return $this->background;
    }

    public function setBackground(?Background $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getEffect(): ?Effect
    {
        return $this->effect;
    }

    public function setEffect(?Effect $effect): static
    {
        $this->effect = $effect;

        return $this;
    }
}
