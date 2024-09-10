<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto\Response\Transformer;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{
    public function transformFromObjects(iterable $objects, string $unit = 'g'): iterable
    {
        $dto = [];

        foreach($objects as $object) {
            $dto[] = $this->transformFromObject($object, $unit);
        }

        return $dto;
    }
}