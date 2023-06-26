<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $tag;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $idIMG;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getIdIMG(): ?int
    {
        return $this->idIMG;
    }

    public function setIdIMG(?int $idIMG): self
    {
        $this->idIMG = $idIMG;

        return $this;
    }
}
