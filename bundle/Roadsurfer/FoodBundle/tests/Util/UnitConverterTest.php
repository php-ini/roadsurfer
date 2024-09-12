<?php

namespace Roadsurfer\FoodBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Util\UnitConverter;

class UnitConverterTest extends TestCase
{
    public function testConvertToGrams()
    {
        $result = UnitConverter::convertToGrams(UnitType::Kilogram, 1);
        $this->assertEquals(1000, $result);

        $result = UnitConverter::convertToGrams(UnitType::Gram, 500);
        $this->assertEquals(500, $result);
    }

    public function testConvertToGramsInvalidQuantity()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit type quantity');

        UnitConverter::convertToGrams(UnitType::Kilogram, -1);
    }

    public function testConvertToKilograms()
    {
        $result = UnitConverter::convertToKilograms(UnitType::Gram, 1000);
        $this->assertEquals(1.0, $result);

        $result = UnitConverter::convertToKilograms(UnitType::Kilogram, 2);
        $this->assertEquals(2.0, $result);
    }

    public function testConvertToKilogramsInvalidQuantity()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit type quantity');

        UnitConverter::convertToKilograms(UnitType::Gram, -1);
    }
}