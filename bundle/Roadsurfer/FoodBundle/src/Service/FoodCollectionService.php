<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Service;

use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;
use Roadsurfer\FoodBundle\Util\UnitConverter;
use Roadsurfer\FoodBundle\Collection\FruitsCollection;
use Roadsurfer\FoodBundle\Collection\VegetablesCollection;

readonly class FoodCollectionService
{
    public function __construct(
        private FruitsCollection     $fruitsCollection,
        private VegetablesCollection $vegetablesCollection
    )
    {
    }

    public function processJson(array $items): void
    {
        foreach ($items as $item) {
            $itemType = FoodType::tryFrom($item['type']);

            switch ($itemType) {
                case FoodType::Fruit:

                    $fruitsDto = new FruitsDto(
                        $item['id'],
                        $item['name'],
                        UnitConverter::convertToGrams($item),
                        $item['unit']
                    );
                    $this->fruitsCollection->add($fruitsDto);
                    break;
                case FoodType::Vegetable:

                    $vegetableDto = new VegetablesDto(
                        $item['id'],
                        $item['name'],
                        UnitConverter::convertToGrams($item),
                        $item['unit']
                    );
                    $this->vegetablesCollection->add($vegetableDto);
                    break;
            }
        }
    }

    public function getFruits(): array
    {
        return $this->fruitsCollection->list();
    }

    public function getVegetables(): array
    {
        return $this->vegetablesCollection->list();
    }
}
