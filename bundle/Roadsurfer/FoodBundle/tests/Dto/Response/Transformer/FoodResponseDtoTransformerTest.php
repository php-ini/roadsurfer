<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Tests\Dto\Response\Transformer;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Dto\Response\FoodsResponseDto;
use Roadsurfer\FoodBundle\Dto\Response\Transformer\FoodResponseDtoTransformer;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Util\UnitConverter;

class FoodResponseDtoTransformerTest extends TestCase
{
    private FoodResponseDtoTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new FoodResponseDtoTransformer();
    }

    public function testTransformFromObjectWithGramUnit(): void
    {
        $food = $this->createMock(Food::class);
        $food->method('getId')->willReturn(1);
        $food->method('getName')->willReturn('Apple');
        $food->method('getType')->willReturn('Fruit');
        $food->method('getQuantity')->willReturn(100);
        $food->method('getUnit')->willReturn(UnitType::Gram);
        $food->method('getCreatedAt')->willReturn(new \DateTime('2023-01-01 00:00:00'));

        $dto = $this->transformer->transformFromObject($food, UnitType::Gram);

        $this->assertInstanceOf(FoodsResponseDto::class, $dto);
        $this->assertEquals(1, $dto->id);
        $this->assertEquals('Apple', $dto->name);
        $this->assertEquals('Fruit', $dto->type);
        $this->assertEquals(100, $dto->quantity);
        $this->assertEquals(UnitType::Gram, $dto->unit);
        $this->assertEquals('2023-01-01 00:00:00', $dto->createdAt);
    }

    public function testTransformFromObjectWithKilogramUnit(): void
    {
        $food = $this->createMock(Food::class);
        $food->method('getId')->willReturn(1);
        $food->method('getName')->willReturn('Apple');
        $food->method('getType')->willReturn('Fruit');
        $food->method('getQuantity')->willReturn(1000);
        $food->method('getUnit')->willReturn(UnitType::Gram);
        $food->method('getCreatedAt')->willReturn(new \DateTime('2023-01-01 00:00:00'));

        $dto = $this->transformer->transformFromObject($food, UnitType::Kilogram);

        $this->assertInstanceOf(FoodsResponseDto::class, $dto);
        $this->assertEquals(1, $dto->id);
        $this->assertEquals('Apple', $dto->name);
        $this->assertEquals('Fruit', $dto->type);
        $this->assertEquals(1, $dto->quantity); // 1000 grams = 1 kilogram
        $this->assertEquals(UnitType::Kilogram, $dto->unit);
        $this->assertEquals('2023-01-01 00:00:00', $dto->createdAt);
    }
}