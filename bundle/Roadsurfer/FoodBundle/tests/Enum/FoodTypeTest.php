<?php

namespace Roadsurfer\FoodBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Enum\FoodType;

class FoodTypeTest extends TestCase
{
    public function testFoodTypeValues()
    {
        $this->assertEquals('fruit', FoodType::Fruit->value);
        $this->assertEquals('vegetable', FoodType::Vegetable->value);
    }

    public function testFoodTypeKeys()
    {
        $this->assertEquals('Fruit', FoodType::Fruit->name);
        $this->assertEquals('Vegetable', FoodType::Vegetable->name);
    }
}