<?php

namespace Roadsurfer\FoodBundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Factory\FoodFactory;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;

class FoodFactoryTest extends TestCase
{
    private FoodFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new FoodFactory();
    }

    public function testCreateFood()
    {
        $item = [
            'name' => 'Apple',
            'type' => 'fruit',
            'quantity' => 10,
            'unit' => 'kg'
        ];

        $food = $this->factory->create($item);

        $this->assertInstanceOf(Food::class, $food);
        $this->assertEquals('Apple', $food->getName());
        $this->assertEquals(FoodType::Fruit, $food->getType());
        $this->assertEquals(10000, $food->getQuantity()); // Assuming 1 kg = 1000 g
        $this->assertEquals(UnitType::Gram, $food->getUnit());
        $this->assertInstanceOf(\DateTimeImmutable::class, $food->getCreatedAt());
    }

    public function testCreateInvalidFoodType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid food type');

        $item = [
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
            'name' => 'Apple',
            'type' => 'fruit',
            'quantity' => 1,
            'unit' => 'unknown'
        ];

        $this->factory->create($item);
    }
}