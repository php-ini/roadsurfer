<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

interface CollectionInterface
{
    public function add(array $item): void;
    public function remove(int $id): void;
    public function list(): array;
    public function search(string $filter): array;
}