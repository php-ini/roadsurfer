<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto;

use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Symfony\Component\Validator\Constraints as Assert;

abstract class FoodDto implements FoodDtoInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private readonly int $id;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=255)
     */
    private readonly string $name;

    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\Positive
     */
    private readonly int $quantity;

    /**
     * @Assert\NotBlank
     * @Assert\Type("enum")
     */
    private readonly UnitType $unit;

    public function __construct(
        int $id,
        string $name,
        int $quantity,
        UnitType $unit
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unit = $unit;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnit(): UnitType
    {
        return $this->unit;
    }

    abstract public function getType(): FoodType;
}