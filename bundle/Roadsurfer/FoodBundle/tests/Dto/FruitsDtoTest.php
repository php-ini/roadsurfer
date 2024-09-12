<?php

namespace Roadsurfer\FoodBundle\Tests\Dto;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FruitsDtoTest extends TestCase
{
    public function testFruitsDto()
    {
        $unit = UnitType::Kilogram;
        $dto = new FruitsDto(1, 'Apple', 10, $unit);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('Apple', $dto->getName());
        $this->assertEquals(10, $dto->getQuantity());
        $this->assertEquals($unit, $dto->getUnit());
        $this->assertEquals(FoodType::Fruit, $dto->getType());
    }
}