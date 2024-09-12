<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response\Transformer;

use Roadsurfer\FoodBundle\Enum\UnitType;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{
    public function transformFromObjects(iterable $objects, UnitType $unit = UnitType::Gram): iterable
    {
        $dto = [];

        foreach($objects as $object) {
            $dto[] = $this->transformFromObject($object, $unit);
        }

        return $dto;
    }
}