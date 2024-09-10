<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Repository;

use Roadsurfer\FoodBundle\Entity\Food;

interface FoodRepositoryInterface
{
    public function save(Food $food, bool $flush): void;

    public function remove(Food $food, bool $flush): void;

    public function findAll(): array;
}