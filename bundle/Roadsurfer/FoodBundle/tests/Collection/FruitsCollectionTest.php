<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Tests\Collection;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Collection\FruitsCollection;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;
use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;

class FruitsCollectionTest extends TestCase
{
    private FruitsCollection $fruitsCollection;

    protected function setUp(): void
    {
        $this->fruitsCollection = new FruitsCollection();
    }

    public function testAddFruitsDto(): void
    {
        $fruit = $this->createMock(FruitsDto::class);
        $fruit->method('getId')->willReturn(1);

        $this->fruitsCollection->add($fruit);

        $this->assertCount(1, $this->fruitsCollection->list());
        $this->assertSame($fruit, $this->fruitsCollection->list()[1]);
    }

    public function testAddNonFruitsDtoThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Only FruitsDto is allowed in FruitsCollection');

        $vegetable = $this->createMock(VegetablesDto::class);
        $this->fruitsCollection->add($vegetable);
    }

    public function testRemove(): void
    {
        $fruit = $this->createMock(FruitsDto::class);
        $fruit->method('getId')->willReturn(1);

        $this->fruitsCollection->add($fruit);
        $this->fruitsCollection->remove(1);

        $this->assertCount(0, $this->fruitsCollection->list());
    }

    public function testList(): void
    {
        $fruit1 = $this->createMock(FruitsDto::class);
        $fruit1->method('getId')->willReturn(1);

        $fruit2 = $this->createMock(FruitsDto::class);
        $fruit2->method('getId')->willReturn(2);

        $this->fruitsCollection->add($fruit1);
        $this->fruitsCollection->add($fruit2);

        $this->assertCount(2, $this->fruitsCollection->list());
        $this->assertSame($fruit1, $this->fruitsCollection->list()[1]);
        $this->assertSame($fruit2, $this->fruitsCollection->list()[2]);
    }
}