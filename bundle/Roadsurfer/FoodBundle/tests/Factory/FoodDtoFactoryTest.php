<?php

namespace Roadsurfer\FoodBundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Factory\FoodDtoFactory;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FoodDtoFactoryTest extends TestCase
{
    private FoodDtoFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new FoodDtoFactory();
    }

    public function testCreateFruitsDto()
    {
        $item = [
            'id' => 1,
            'name' => 'Apple',
            'type' => 'fruit',
            'quantity' => 10,
            'unit' => 'kg'
        ];

        $dto = $this->factory->create($item);

        $this->assertInstanceOf(FruitsDto::class, $dto);
        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('Apple', $dto->getName());
        $this->assertEquals(10, $dto->getQuantity());
        $this->assertEquals(UnitType::Kilogram, $dto->getUnit());
        $this->assertEquals(FoodType::Fruit, $dto->getType());
    }

    public function testCreateVegetablesDto()
    {
        $item = [
            'id' => 2,
            'name' => 'Carrot',
            'type' => 'vegetable',
            'quantity' => 5,
            'unit' => 'g'
        ];

        $dto = $this->factory->create($item);

        $this->assertInstanceOf(VegetablesDto::class, $dto);
        $this->assertEquals(2, $dto->getId());
        $this->assertEquals('Carrot', $dto->getName());
        $this->assertEquals(5, $dto->getQuantity());
        $this->assertEquals(UnitType::Gram, $dto->getUnit());
        $this->assertEquals(FoodType::Vegetable, $dto->getType());
    }

    public function testCreateInvalidFoodType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid food type');

        $item = [
            'id' => 3,
            'name' => 'Unknown',
            'type' => 'unknown',
            'quantity' => 1,
            'unit' => 'kg'
        ];

        $this->factory->create($item);
    }

    public function testCreateInvalidUnitType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit type');

        $item = [
            'id' => 4,
            'name' => 'Apple',
            'type' => 'fruit',
            'quantity' => 1,
            'unit' => 'unknown'
        ];

        $this->factory->create($item);
    }
}