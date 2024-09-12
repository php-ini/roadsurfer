<?php

namespace Roadsurfer\FoodBundle\Tests\Dto;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Dto\FoodDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FoodDtoTest extends TestCase
{
    public function testFoodDto()
    {
        $unit = UnitType::Kilogram;
        $dto = $this->getMockForAbstractClass(
            FoodDto::class,
            [1, 'Apple', 10, $unit]
        );

        $dto->method('getType')->willReturn(FoodType::Fruit);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('Apple', $dto->getName());
        $this->assertEquals(10, $dto->getQuantity());
        $this->assertEquals($unit, $dto->getUnit());
        $this->assertEquals(FoodType::Fruit, $dto->getType());
    }
}