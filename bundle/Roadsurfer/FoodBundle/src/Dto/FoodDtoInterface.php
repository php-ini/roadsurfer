<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto;

use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

interface FoodDtoInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getType(): FoodType;
    public function getQuantity(): int;
    public function getUnit(): UnitType;

}