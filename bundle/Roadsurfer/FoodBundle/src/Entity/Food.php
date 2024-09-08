<?php

namespace Roadsurfer\FoodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(enumType: FoodType::class)]
    #[Assert\Choice(choices: [FoodType::Fruit, FoodType::Vegetable], message: 'Choose a valid food type.')]
    private ?FoodType $type = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $quantity = null;

    #[ORM\Column(enumType: UnitType::class)]
    #[Assert\Choice(choices: [UnitType::Gram, UnitType::Kilogram], message: 'Choose a valid unit type.')]
    private ?UnitType $unit = null;

    #[ORM\Column(type: "datetime", nullable: false, insertable: false)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?FoodType
    {
        return $this->type;
    }

    public function setType(FoodType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?UnitType
    {
        return $this->unit;
    }

    public function setUnit(UnitType $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        if (!$this->createdAt) {
            $this->createdAt = new \DateTime();
        }
    }
}
