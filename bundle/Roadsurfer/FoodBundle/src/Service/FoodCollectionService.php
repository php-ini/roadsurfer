<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Service;

use Roadsurfer\FoodBundle\Collection\FoodCollection;
use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;
use Roadsurfer\FoodBundle\Factory\FoodEntityFactory;
use Roadsurfer\FoodBundle\Repository\FoodRepository;

readonly class FoodCollectionService
{
    public function __construct(
        private FoodRepository    $foodRepository,
        private FoodEntityFactory $foodEntityFactory,
    )
    {
    }

    public function insert(FoodCollection $collection): void
    {
        foreach ($collection->list() as $item) {

            if (!$item instanceof FruitsDto && !$item instanceof VegetablesDto) {
                throw new \InvalidArgumentException('Invalid food type');
            }

            $food = $this->foodEntityFactory->createFromFoodDto($item);
            $this->foodRepository->save($food);
        }
    }
}
