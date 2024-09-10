<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Util;

use Roadsurfer\FoodBundle\Enum\UnitType;

class UnitConverter
{
    public static function convertToGrams(array $item): int
    {
        $unitType = UnitType::tryFrom($item['unit']);

        if (!is_int($item['quantity']) || $item['quantity'] <= 0) {
            throw new \InvalidArgumentException('Invalid unit type quantity');
        }

        if ($unitType === UnitType::Kilogram) {
            $item['quantity'] *= 1000;
        }

        return $item['quantity'];
    }

    public static function convertToKilograms(array $item): float
    {
        $unitType = $item['unit'];

        if (!is_int($item['quantity']) || $item['quantity'] <= 0) {
            throw new \InvalidArgumentException('Invalid unit type quantity');
        }

        if ($unitType === UnitType::Gram) {
            $item['quantity'] /= 1000;
        }

        return $item['quantity'];
    }
}
