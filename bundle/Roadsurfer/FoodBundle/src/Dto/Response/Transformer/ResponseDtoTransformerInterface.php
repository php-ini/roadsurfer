<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response\Transformer;

use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Dto\Response\FoodsResponseDto;

interface ResponseDtoTransformerInterface
{
    public function transformFromObject(Food $food, string $unit = 'g'): FoodsResponseDto;

    public function transformFromObjects(iterable $objects, string $unit): iterable;
}