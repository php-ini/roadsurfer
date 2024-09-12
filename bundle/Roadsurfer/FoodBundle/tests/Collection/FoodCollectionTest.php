<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Tests\Collection;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Collection\FoodCollection;
use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;

class FoodCollectionTest extends TestCase
{
    private $foodCollection;

    protected function setUp(): void
    {
        $this->foodCollection = $this->getMockForAbstractClass(FoodCollection::class);
    }

    public function testAdd(): void
    {
        $foodItem = $this->createMock(FoodDtoInterface::class);
        $foodItem->method('getId')->willReturn(1);

        $this->foodCollection->add($foodItem);

        $this->assertCount(1, $this->foodCollection->list());
        $this->assertSame($foodItem, $this->foodCollection->list()[1]);
    }

    public function testRemove(): void
    {
        $foodItem = $this->createMock(FoodDtoInterface::class);
        $foodItem->method('getId')->willReturn(1);

        $this->foodCollection->add($foodItem);
        $this->foodCollection->remove(1);

        $this->assertCount(0, $this->foodCollection->list());
    }

    public function testList(): void
    {
        $foodItem1 = $this->createMock(FoodDtoInterface::class);
        $foodItem1->method('getId')->willReturn(1);

        $foodItem2 = $this->createMock(FoodDtoInterface::class);
        $foodItem2->method('getId')->willReturn(2);

        $this->foodCollection->add($foodItem1);
        $this->foodCollection->add($foodItem2);

        $this->assertCount(2, $this->foodCollection->list());
        $this->assertSame($foodItem1, $this->foodCollection->list()[1]);
        $this->assertSame($foodItem2, $this->foodCollection->list()[2]);
    }

    public function testSearch(): void
    {
        $result = $this->foodCollection->search('filter');
        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }
}