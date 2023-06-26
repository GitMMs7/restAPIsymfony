<?php

namespace App\Entity;

use App\Repository\PosilkiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosilkiRepository::class)]
class Posilki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $idIMG;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $cena;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $aktywne;

    #[ORM\Column(type: 'string', length: 255)]
    private $opisy;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCena(): ?string
    {
        return $this->cena;
    }

    public function setCena(string $cena): self
    {
        $this->cena = $cena;

        return $this;
    }

    public function getAktywne(): ?bool
    {
        return $this->aktywne;
    }

    public function setAktywne(?bool $aktywne): self
    {
        $this->aktywne = $aktywne;

        return $this;
    }

    public function getOpisy(): ?string
    {
        return $this->opisy;
    }

    public function setOpisy(string $opisy): self
    {
        $this->opisy = $opisy;

        return $this;
    }
}
