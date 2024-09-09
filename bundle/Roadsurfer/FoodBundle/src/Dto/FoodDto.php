<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto;

use Doctrine\ORM\Cache\Exception\FeatureNotImplemented;

abstract class FoodDto implements FoodDtoInterface
{
    public function __construct(
        private readonly int    $id,
        private readonly string $name,
        private readonly float  $quantity,
        private readonly string $unit
    ) {
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

    public function getUnit(): string
    {
        return $this->unit;
    }

    abstract public function getType(): string;

}