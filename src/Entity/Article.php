<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min : 10,max : 255,minMessage : "Your title name must be at least 10 characters long", maxMessage : "Your first name cannot be longer than 255 characters")]
    private $title;
    #[ORM\Column(type: 'text')]
    #[Assert\Length(min : 10)]
    private $content;
     #[ORM\Column(type: 'text', length: 255)]
    #[Assert\Url()]
    private $image;
    

    #[ORM\Column]
    private ?\DateTimeImmutable $createdata = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedata(): ?\DateTimeImmutable
    {
        return $this->createdata;
    }

    public function setCreatedata(\DateTimeImmutable $createdata): static
    {
        $this->createdata = $createdata;

        return $this;
    }
}
