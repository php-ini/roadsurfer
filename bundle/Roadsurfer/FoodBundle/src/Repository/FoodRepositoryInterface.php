<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Repository;
interface FoodRepositoryInterface
{
    public function find();

    public function findBy(string $key, string $value): array;

    public function save(): void;

    public function findAll(): array;
}