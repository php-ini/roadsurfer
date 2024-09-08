<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

abstract class FoodCollection implements CollectionInterface
{
    protected array $foods = [];

    public function add(array $item): void
    {
        $this->foods[$item['id']] = $item;
    }

    public function remove(int $id): void
    {
        unset($this->foods[$id]);
    }

    public function list(): array
    {
        return $this->foods;
    }

    public function search(string $filter): array
    {
        return [];
    }
}