<?php

namespace App\Entity;

use App\Repository\ImgRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImgRepository::class)]
class Img
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresIMG;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nazwa;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $opisy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresIMG(): ?string
    {
        return $this->adresIMG;
    }

    public function setAdresIMG(string $adresIMG): self
    {
        $this->adresIMG = $adresIMG;

        return $this;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(?string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getOpisy(): ?string
    {
        return $this->opisy;
    }

    public function setOpis(?string $opisy): self
    {
        $this->opisy = $opisy;

        return $this;
    }
}
