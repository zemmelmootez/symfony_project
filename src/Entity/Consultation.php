<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $num_carte = null;

    #[ORM\Column]
    private ?int $date = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\Column]
    private ?int $tension = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCarte(): ?string
    {
        return $this->num_carte;
    }

    public function setNumCarte(string $num_carte): static
    {
        $this->num_carte = $num_carte;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTension(): ?int
    {
        return $this->tension;
    }

    public function setTension(int $tension): static
    {
        $this->tension = $tension;

        return $this;
    }
}
