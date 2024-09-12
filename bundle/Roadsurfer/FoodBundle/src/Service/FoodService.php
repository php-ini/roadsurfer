<?php

namespace Roadsurfer\FoodBundle\Service;

use Doctrine\ORM\EntityNotFoundException;
use Roadsurfer\FoodBundle\Collection\FruitsCollection;
use Roadsurfer\FoodBundle\Collection\VegetablesCollection;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Factory\FoodDtoFactory;
use Roadsurfer\FoodBundle\Factory\FoodFactory;
use Roadsurfer\FoodBundle\Repository\FoodRepository;

class FoodService
{
    public function __construct(
        private readonly FoodRepository $foodRepository,
        private readonly FoodFactory $foodFactory,
        private readonly FoodDtoFactory $foodDtoFactory
    )
    {
    }

    public function processJson(array $jsonData): array
    {
        $fruitCollection = new FruitsCollection();
        $vegetablesCollection = new VegetablesCollection();

        foreach ($jsonData as $item) {
            try {
                $foodType = FoodType::from($item['type']);
            } catch (\ValueError $e) {
                $io->error("Invalid food type: " . PHP_EOL . $e->getMessage());
                continue;
            }

            $foodDto =  $this->foodDtoFactory->create($item);

            match ($foodType) {
                FoodType::Fruit => $fruitCollection->add($foodDto),
                FoodType::Vegetable => $vegetablesCollection->add($foodDto),
                default => throw new \Exception('Unexpected Food type value'),
            };
        }

        return [$fruitCollection, $vegetablesCollection];
    }

    public function updateEntity(Food $food, array $data): Food
    {
        if (!$food instanceof Food) {
            throw new EntityNotFoundException('No Entity found');
        }

        $newFood = $this->foodFactory->create($data);

        if (isset($data['name'])) {
            $food->setName($newFood->getName());
        }

        if (isset($data['type'])) {
            $food->setType($newFood->getType());
        }

        if (isset($data['quantity'])) {
            $food->setQuantity($newFood->getQuantity());
        }

        if (isset($data['unit'])) {
            $food->setUnit($newFood->getUnit());
        }

        // Set the updated_at timestamp
        $food->setUpdatedAt(new \DateTimeImmutable());

        return $food;
    }

    public function search(
        ?string $name,
        ?string $type,
        UnitType $unit,
        ?int $minQuantity,
        ?int $maxQuantity
    ): array {
        if ($minQuantity) {
            if ($unit === UnitType::Kilogram) {
                $minQuantity *= 1000;
            }
        }

        if ($maxQuantity) {
            if ($unit === UnitType::Kilogram) {
                $maxQuantity *= 1000;
            }
        }

        return $this->foodRepository->search($name, $type, $minQuantity, $maxQuantity);
    }
}