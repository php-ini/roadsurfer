<?php

namespace Roadsurfer\FoodBundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Factory\FoodEntityFactory;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FoodEntityFactoryTest extends TestCase
{
    private FoodEntityFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new FoodEntityFactory();
    }

    public function testCreateFromFoodDto()
    {
        $dto = new FruitsDto(1, 'Apple', 10, UnitType::Kilogram);

        $food = $this->factory->createFromFoodDto($dto);

        $this->assertInstanceOf(Food::class, $food);
        $this->assertEquals('Apple', $food->getName());
        $this->assertEquals(UnitType::Gram, $food->getUnit());
        $this->assertEquals(FoodType::Fruit, $food->getType());
        $this->assertEquals(10000, $food->getQuantity()); // Assuming 1 kg = 1000 g
        $this->assertInstanceOf(\DateTimeImmutable::class, $food->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $food->getUpdatedAt());
    }

    public function testConvertToGramsInvalidUnit()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit type quantity');

        $dto = new FruitsDto(1, 'Apple', 10, UnitType::tryFrom('unknown'));

        $this->factory->createFromFoodDto($dto);
    }
}