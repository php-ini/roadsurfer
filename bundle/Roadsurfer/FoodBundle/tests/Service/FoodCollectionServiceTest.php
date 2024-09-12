<?php

namespace Roadsurfer\FoodBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Collection\FoodCollection;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Factory\FoodEntityFactory;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Roadsurfer\FoodBundle\Service\FoodCollectionService;

class FoodCollectionServiceTest extends TestCase
{
    private FoodRepository $foodRepository;
    private FoodEntityFactory $foodEntityFactory;
    private FoodCollectionService $foodCollectionService;

    protected function setUp(): void
    {
        $this->foodRepository = $this->createMock(FoodRepository::class);
        $this->foodEntityFactory = $this->createMock(FoodEntityFactory::class);
        $this->foodCollectionService = new FoodCollectionService($this->foodRepository, $this->foodEntityFactory);
    }

    public function testInsertValidCollection()
    {
        $fruitsDto = new FruitsDto(1, 'Apple', 10, UnitType::Kilogram);
        $vegetablesDto = new VegetablesDto(2, 'Carrot', 5, UnitType::Gram);

        $collection = new FoodCollection([$fruitsDto, $vegetablesDto]);

        $food1 = new Food();
        $food2 = new Food();

        $this->foodEntityFactory->method('createFromFoodDto')
            ->willReturnOnConsecutiveCalls($food1, $food2);

        $this->foodRepository->expects($this->exactly(2))
            ->method('save')
            ->withConsecutive([$food1], [$food2]);

        $this->foodCollectionService->insert($collection);
    }

    public function testInsertInvalidFoodType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid food type');

        $invalidDto = $this->createMock(FruitsDto::class);
        $collection = new FoodCollection([$invalidDto]);

        $this->foodCollectionService->insert($collection);
    }
}