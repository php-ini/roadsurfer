<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

use Roadsurfer\FoodBundle\Dto\FruitsDto;
use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;

class FruitsCollection extends FoodCollection
{
    #[\Override]
    public function add(FoodDtoInterface $item): void
    {
        if (!$item instanceof FruitsDto) {
            throw new \InvalidArgumentException('Only FruitsDto is allowed in FruitsCollection');
        }
        parent::add($item);
    }
}