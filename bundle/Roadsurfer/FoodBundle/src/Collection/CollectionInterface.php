<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;

interface CollectionInterface
{
    public function add(FruitsDto|VegetablesDto $item): void;
    public function remove(int $id): void;
    public function list(): array;
    public function search(string $filter): array;
}