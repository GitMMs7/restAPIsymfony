<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutable;
use App\Entity\Traits\TimeStampableTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements \JsonSerializable
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Column(type: 'integer')]
    private $id;

    #[Column(type: 'string', length: 255)]
    private $name;

    #[Column(type: 'text')]
    private $content;

    #[Column(type: 'integer')]
    private $grupa;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    public function setId(int $id): ?int
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getGrupa(): ?int
    {
        return $this->grupa;
    }

    public function setGrupa(int $grupa): self
    {
        $this->grupa = $grupa;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $createdAt = new \DateTimeImmutable();
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): self
    {
        $updatedAt = new \DateTimeImmutable();
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "name" => $this->getName(),
            "content" => $this->getContent(),
            "grupa" => $this->getGrupa(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
    public function asArray(): array
    {
        return [
            'id' => $this->Id,
            'content' => $this->content,
            'grupa' => $this->grupa,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }

}
