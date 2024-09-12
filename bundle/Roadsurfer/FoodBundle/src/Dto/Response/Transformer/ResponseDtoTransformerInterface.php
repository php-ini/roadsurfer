<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response\Transformer;

use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Dto\Response\FoodsResponseDto;
use Roadsurfer\FoodBundle\Enum\UnitType;

interface ResponseDtoTransformerInterface
{
    public function transformFromObject(Food $food, UnitType $unit = UnitType::Gram): FoodsResponseDto;

    public function transformFromObjects(iterable $objects, UnitType $unit = UnitType::Gram): iterable;
}