<?php

namespace Roadsurfer\FoodBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Collection\FruitsCollection;
use Roadsurfer\FoodBundle\Collection\VegetablesCollection;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Factory\FoodDtoFactory;
use Roadsurfer\FoodBundle\Factory\FoodFactory;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Roadsurfer\FoodBundle\Service\FoodService;
use Doctrine\ORM\EntityNotFoundException;

class FoodServiceTest extends TestCase
{
    private FoodRepository $foodRepository;
    private FoodFactory $foodFactory;
    private FoodDtoFactory $foodDtoFactory;
    private FoodService $foodService;

    protected function setUp(): void
    {
        $this->foodRepository = $this->createMock(FoodRepository::class);
        $this->foodFactory = $this->createMock(FoodFactory::class);
        $this->foodDtoFactory = $this->createMock(FoodDtoFactory::class);
        $this->foodService = new FoodService($this->foodRepository, $this->foodFactory, $this->foodDtoFactory);
    }

    public function testProcessJson()
    {
        $jsonData = [
            ['id' => 1, 'name' => 'Apple', 'type' => 'fruit', 'quantity' => 10, 'unit' => 'kg'],
            ['id' => 2, 'name' => 'Carrot', 'type' => 'vegetable', 'quantity' => 5, 'unit' => 'g']
        ];

        $fruitDto = $this->createMock(FruitsDto::class);
        $vegetableDto = $this->createMock(VegetablesDto::class);

        $this->foodDtoFactory->method('create')
            ->willReturnOnConsecutiveCalls($fruitDto, $vegetableDto);

        [$fruitCollection, $vegetablesCollection] = $this->foodService->processJson($jsonData);

        $this->assertInstanceOf(FruitsCollection::class, $fruitCollection);
        $this->assertInstanceOf(VegetablesCollection::class, $vegetablesCollection);
        $this->assertCount(1, $fruitCollection->list());
        $this->assertCount(1, $vegetablesCollection->list());
    }

    public function testUpdateEntity()
    {
        $food = new Food();
        $data = ['name' => 'Banana', 'type' => 'fruit', 'quantity' => 20, 'unit' => 'kg'];

        $newFood = new Food();
        $newFood->setName('Banana');
        $newFood->setType(FoodType::Fruit);
        $newFood->setQuantity(20000); // Assuming 20 kg = 20000 g
        $newFood->setUnit(UnitType::Gram);

        $this->foodFactory->method('create')->willReturn($newFood);

        $updatedFood = $this->foodService->updateEntity($food, $data);

        $this->assertEquals('Banana', $updatedFood->getName());
        $this->assertEquals(FoodType::Fruit, $updatedFood->getType());
        $this->assertEquals(20000, $updatedFood->getQuantity());
        $this->assertEquals(UnitType::Gram, $updatedFood->getUnit());
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedFood->getUpdatedAt());
    }

    public function testUpdateEntityNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('No Entity found');

        $this->foodService->updateEntity(null, []);
    }

    public function testSearch()
    {
        $food = new Food();
        $food->setName('Apple');
        $food->setType(FoodType::Fruit);
        $food->setQuantity(1000);
        $food->setUnit(UnitType::Gram);

        $this->foodRepository->method('search')->willReturn([$food]);

        $results = $this->foodService->search('Apple', 'fruit', UnitType::Gram, 1, 1000);

        $this->assertCount(1, $results);
        $this->assertEquals('Apple', $results[0]->getName());
    }
}