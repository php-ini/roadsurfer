<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Util;

use Roadsurfer\FoodBundle\Enum\UnitType;

class UnitConverter
{
    public static function convertToGrams(array $item): int
    {
        $unitType = UnitType::tryFrom($item['unit']);

        if ($unitType === UnitType::Kilogram) {
            $item['quantity'] *= 1000;
        }

        return $item['quantity'];
    }
}
