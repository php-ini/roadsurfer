<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Factory;

use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Util\UnitConverter;

final class FoodFactory
{
    public function create(array $food): Food
    {
        $newFood = new Food();
        $foodQuantity = UnitConverter::convertToGrams($food);

        $foodType = FoodType::tryFrom($food['type']);

        if ($foodType === null) {
            throw new \InvalidArgumentException('Invalid food type: ' . $food['type']);
        }

        $unitType = UnitType::tryFrom($food['unit']);

        if ($unitType === null) {
            throw new \InvalidArgumentException('Invalid food type: ' . $food['unit']);
        }

        $newFood->setName($food['name']);
        $newFood->setType(FoodType::from($food['type']));
        $newFood->setQuantity($foodQuantity);
        $newFood->setUnit(UnitType::Gram);

        return $newFood;
    }
}