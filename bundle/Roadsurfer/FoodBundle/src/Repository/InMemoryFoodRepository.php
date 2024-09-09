<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Repository;

class InMemoryFoodRepository implements FoodRepositoryInterface
{
    public function find()
    {
        // TODO: Implement find() method.
    }

    public function save(): void
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
}