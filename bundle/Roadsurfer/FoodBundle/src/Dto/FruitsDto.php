<?php

namespace Roadsurfer\FoodBundle\Dto;

use Roadsurfer\FoodBundle\Enum\FoodType;

class FruitsDto extends FoodDto
{
    public function getType(): string
    {
        return FoodType::Fruit->value;
    }
}