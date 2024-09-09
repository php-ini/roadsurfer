<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Dto;

interface FoodDtoInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getType(): string;
    public function getQuantity(): int;
    public function getUnit(): string;

}