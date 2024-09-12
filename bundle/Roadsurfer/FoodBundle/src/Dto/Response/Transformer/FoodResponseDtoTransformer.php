<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response\Transformer;

use Roadsurfer\FoodBundle\Dto\Response\FoodsResponseDto;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Util\UnitConverter;

class FoodResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    public function transformFromObject(Food $food, UnitType $unit = UnitType::Gram): FoodsResponseDto
    {
        $quantity = $food->getQuantity();

        if (UnitType::Kilogram === $unit) {
            $quantityInKG = UnitConverter::convertToKilograms($food->getUnit(), $quantity);
            $quantity = $quantityInKG;
        }

        $dto = new FoodsResponseDto();
        $dto->id = $food->getId();
        $dto->name = $food->getName();
        $dto->type = $food->getType();
        $dto->quantity = $quantity;
        $dto->unit = $unit ?? UnitType::Gram;

        $dto->createdAt = $food->getCreatedAt()->format('Y-m-d H:i:s');

        return $dto;
    }

}