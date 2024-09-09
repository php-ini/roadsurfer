<?php

namespace Roadsurfer\FoodBundle\Dto;

use Roadsurfer\FoodBundle\Enum\FoodType;

class VegetablesDto extends FoodDto
{
    public function getType(): string
    {
        return FoodType::Vegetable->value;
    }
}