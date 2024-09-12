<?php

namespace Roadsurfer\FoodBundle\Factory;

use Roadsurfer\FoodBundle\Dto\FoodDto;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Util\UnitConverter;

class FoodEntityFactory
{
    public function createFromFoodDto(FoodDto $foodDto): Food
    {
        $food = new Food();
        $food->setName($foodDto->getName());
        $food->setUnit(UnitType::Gram);
        $food->setType($foodDto->getType());
        $food->setQuantity($this->convertToGrams($foodDto));
        $food->setCreatedAt(new \DateTimeImmutable());
        $food->setUpdatedAt(new \DateTimeImmutable());
        return $food;
    }

    private function convertToGrams(FoodDto $foodDto): int
    {
        try {
            return UnitConverter::convertToGrams($foodDto->getUnit(), $foodDto->getQuantity());
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid unit type quantity');
        }
    }

}