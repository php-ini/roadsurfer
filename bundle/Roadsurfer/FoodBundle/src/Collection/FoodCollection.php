<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;

abstract class FoodCollection implements CollectionInterface
{
//    public function __construct(private readonly \FoodRepositoryInterface $foodRepository)
//    {
//    }

    protected array $foods = [];

    public function add(FoodDtoInterface $item): void
    {
        $this->foods[$item->getId()] = $item;
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