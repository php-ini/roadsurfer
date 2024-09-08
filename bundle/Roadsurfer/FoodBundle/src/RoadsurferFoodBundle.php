<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Roadsurfer\FoodBundle\DependencyInjection\RoadsurferFoodBundleExtension;

class RoadsurferFoodBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new RoadsurferFoodBundleExtension();
    }
}