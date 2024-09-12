<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Factory;

use Roadsurfer\FoodBundle\Dto\FoodDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;

final class FoodDtoFactory
{
    public function create(array $item): FoodDto
    {
        $this->validate($item);

        $unitType = UnitType::tryFrom($item['unit']);
        $foodType = FoodType::tryFrom($item['type']);

        try {
            return match ($foodType) {
                FoodType::Fruit => new FruitsDto(
                    $item['id'],
                    $item['name'],
                    $item['quantity'],
                    $unitType
                ),
                FoodType::Vegetable => new VegetablesDto(
                    $item['id'],
                    $item['name'],
                    $item['quantity'],
                    $unitType
                ),
            };
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid food type');
        }
    }

    private function validate(array $food): void
    {
        if (!isset($food['name'])) {
            throw new \InvalidArgumentException('Name is required');
        }

        if (!isset($food['type'])) {
            throw new \InvalidArgumentException('Type is required');
        }

        if(!FoodType::tryFrom($food['type']) instanceof FoodType) {
            throw new \InvalidArgumentException('Invalid food type');
        }

        if (!isset($food['quantity'])) {
            throw new \InvalidArgumentException('Quantity is required');
        }

        if (!isset($food['unit'])) {
            throw new \InvalidArgumentException('Unit is required');
        }

        if(!UnitType::tryFrom($food['unit']) instanceof UnitType) {
            throw new \InvalidArgumentException('Invalid unit type');
        }
    }

}