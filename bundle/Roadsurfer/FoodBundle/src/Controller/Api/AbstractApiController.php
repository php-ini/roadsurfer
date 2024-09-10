<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;

abstract class AbstractApiController extends AbstractFOSRestController
{
    public function respond($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->json($data, $statusCode);
    }
}