<?php

namespace App\Entity;

use App\Repository\NazwyPotrawRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NazwyPotrawRepository::class)]
class NazwyPotraw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $idJezyk;

    #[ORM\Column(type: 'string', length: 255)]
    private $NazwaPotraw;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdJezyk(): ?int
    {
        return $this->idJezyk;
    }

    public function setIdJezyk(int $idJezyk): self
    {
        $this->idJezyk = $idJezyk;

        return $this;
    }

    public function getNazwaPotraw(): ?string
    {
        return $this->NazwaPotraw;
    }

    public function setNazwaPotraw(string $NazwaPotraw): self
    {
        $this->NazwaPotraw = $NazwaPotraw;

        return $this;
    }
}
