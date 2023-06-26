<?php

namespace App\Entity;

use App\Repository\SkladnikiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkladnikiRepository::class)]
class Skladniki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $skladnik;

    #[ORM\Column(type: 'integer')]
    private $idJezyk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkladnik(): ?string
    {
        return $this->skladnik;
    }

    public function setSkladnik(string $skladnik): self
    {
        $this->skladnik = $skladnik;

        return $this;
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
}
