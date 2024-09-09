<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Collection;

use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;
use Roadsurfer\FoodBundle\Dto\VegetablesDto;

class VegetablesCollection extends FoodCollection
{
    #[\Override]
    public function add(FoodDtoInterface $item): void
    {
        if (!$item instanceof VegetablesDto) {
            throw new \InvalidArgumentException('Only VegetablesDto is allowed in VegetablesCollection');
        }
        parent::add($item);
    }
}