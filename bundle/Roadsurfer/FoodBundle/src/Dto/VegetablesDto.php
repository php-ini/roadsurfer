<?php

namespace Roadsurfer\FoodBundle\Dto;

use Roadsurfer\FoodBundle\Enum\FoodType;
use Symfony\Component\Validator\Constraints as Assert;

class VegetablesDto extends FoodDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=255)
     */
    public function getType(): FoodType
    {
        return FoodType::Vegetable;
    }
}