<?php

namespace App\Entity;

use App\Repository\JezykiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JezykiRepository::class)]
class Jezyki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $jezyk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJezyk(): ?string
    {
        return $this->jezyk;
    }

    public function setJezyk(string $jezyk): self
    {
        $this->jezyk = $jezyk;

        return $this;
    }
}
