<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response;

use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use JMS\Serializer\Annotation as Serialization;

class FoodsResponseDto
{
    #[Serialization\Type("int")]
    public int $id;

    #[Serialization\Type("string")]
    public string $name;

    #[Serialization\Type("enum<Roadsurfer\FoodBundle\Enum\FoodType>")]
    public FoodType $type;

    #[Serialization\Type("float")]
    public float $quantity;

    #[Serialization\Type("enum<Roadsurfer\FoodBundle\Enum\Unit>")]
    public UnitType $unit;

    #[Serialization\Type("DateTime<'Y-m-d\TH:i:s'>")]
    public string $createdAt;
}