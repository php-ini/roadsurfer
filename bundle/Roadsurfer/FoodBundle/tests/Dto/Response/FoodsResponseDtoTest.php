<?php

namespace Roadsurfer\FoodBundle\Tests\Dto\Response;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Dto\Response\FoodsResponseDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FoodsResponseDtoTest extends TestCase
{
    public function testFoodsResponseDto()
    {
        $dto = new FoodsResponseDto();
        $dto->id = 1;
        $dto->name = 'Apple';
        $dto->type = FoodType::Fruit;
        $dto->quantity = 10.5;
        $dto->unit = UnitType::Kilogram;
        $dto->createdAt = '2023-10-01T12:00:00';

        $this->assertEquals(1, $dto->id);
        $this->assertEquals('Apple', $dto->name);
        $this->assertEquals(FoodType::Fruit, $dto->type);
        $this->assertEquals(10.5, $dto->quantity);
        $this->assertEquals(UnitType::Kilogram, $dto->unit);
        $this->assertEquals('2023-10-01T12:00:00', $dto->createdAt);
    }
}