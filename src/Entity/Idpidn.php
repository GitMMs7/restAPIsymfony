<?php

namespace App\Entity;

use App\Repository\IdpidnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdpidnRepository::class)]
class Idpidn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $idPosilki;

    #[ORM\Column(type: 'integer')]
    private $idNazwyPotraw;

    #[ORM\Column(type: 'integer')]
    private $idSkladniki;

    #[ORM\Column(type: 'integer')]
    private $idTag;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPosilki(): ?string
    {
        return $this->idPosilki;
    }

    public function setIdPosilki(string $idPosilki): self
    {
        $this->idPosilki = $idPosilki;

        return $this;
    }

    public function getIdNazwyPotraw(): ?string
    {
        return $this->idNazwyPotraw;
    }

    public function setIdNazwyPotraw(string $idNazwyPotraw): self
    {
        $this->idNazwyPotraw = $idNazwyPotraw;

        return $this;
    }

    public function getIdSkladniki(): ?int
    {
        return $this->idSkladniki;
    }

    public function setIdSkladniki(int $idSkladniki): self
    {
        $this->idSkladniki = $idSkladniki;

        return $this;
    }

    public function getIdTag(): ?int
    {
        return $this->idTag;
    }

    public function setIdTag(int $idTag): self
    {
        $this->idTag = $idTag;

        return $this;
    }
}
