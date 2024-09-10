<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Repository;

use Roadsurfer\FoodBundle\Entity\Food;

class InMemoryFoodRepository implements FoodRepositoryInterface
{
    public function find()
    {
        // TODO: Implement find() method.
    }

    public function save(Food $food, bool $flush): void
    {
        // TODO: Implement save() method.
    }

    public function findAll(): array
    {
        return [];
    }

    public function findBy(string $key, string $value): array
    {
        return [];
    }

    public function remove(Food $food, bool $flush): void
    {
        // TODO: Implement remove() method.
    }
}