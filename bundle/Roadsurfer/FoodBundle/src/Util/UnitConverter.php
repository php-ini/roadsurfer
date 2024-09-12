<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Util;

use Roadsurfer\FoodBundle\Enum\UnitType;

class UnitConverter
{
    public static function convertToGrams(UnitType $unitType, int $quantity): int
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Invalid unit type quantity');
        }

        if ($unitType === UnitType::Kilogram) {
            $quantity *= 1000;
        }

        return $quantity;
    }

    public static function convertToKilograms(UnitType $unitType, int $quantity): float
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Invalid unit type quantity');
        }

        if ($unitType === UnitType::Gram) {
            $quantity /= 1000;
        }

        return $quantity;
    }
}
