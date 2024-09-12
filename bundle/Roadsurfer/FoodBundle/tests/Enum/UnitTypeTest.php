<?php

namespace Roadsurfer\FoodBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Enum\UnitType;

class UnitTypeTest extends TestCase
{
    public function testUnitTypeValues()
    {
        $this->assertEquals('g', UnitType::Gram->value);
        $this->assertEquals('kg', UnitType::Kilogram->value);
    }

    public function testUnitTypeKeys()
    {
        $this->assertEquals('Gram', UnitType::Gram->name);
        $this->assertEquals('Kilogram', UnitType::Kilogram->name);
    }
}