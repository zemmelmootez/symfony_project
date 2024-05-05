<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RdvRepository::class)]
class Rdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumRdv = null;

    #[ORM\Column]
    private ?int $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumRdv(): ?int
    {
        return $this->NumRdv;
    }

    public function setNumRdv(int $NumRdv): static
    {
        $this->NumRdv = $NumRdv;

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
}
