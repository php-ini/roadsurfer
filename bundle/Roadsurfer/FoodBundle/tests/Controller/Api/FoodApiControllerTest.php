<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Tests\Controller\Api;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Controller\Api\FoodApiController;
use Roadsurfer\FoodBundle\Dto\FoodDtoInterface;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Roadsurfer\FoodBundle\Dto\Response\Transformer\FoodResponseDtoTransformer;
use Roadsurfer\FoodBundle\Factory\FoodFactory;
use Roadsurfer\FoodBundle\Service\FoodService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FoodApiControllerTest extends TestCase
{
    private $foodRepository;
    private $foodResponseDtoTransformer;
    private $foodFactory;
    private $foodService;
    private $validator;
    private $controller;

    protected function setUp(): void
    {
        $this->foodRepository = $this->createMock(FoodRepository::class);
        $this->foodResponseDtoTransformer = $this->createMock(FoodResponseDtoTransformer::class);
        $this->foodFactory = $this->createMock(FoodFactory::class);
        $this->foodService = $this->createMock(FoodService::class);
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->controller = new FoodApiController(
            $this->foodRepository,
            $this->foodResponseDtoTransformer,
            $this->foodFactory,
            $this->foodService
        );
    }

    public function testAll(): void
    {
        $request = new Request();
        $foods = [];
        $dto = [];

        $this->foodRepository->method('findAll')->willReturn($foods);
        $this->foodResponseDtoTransformer->method('transformFromObjects')->willReturn($dto);

        $response = $this->controller->all($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testSearch(): void
    {
        $request = new Request(['name' => 'apple', 'type' => 'fruit', 'unit' => 'g', 'min_quantity' => 10, 'max_quantity' => 100]);
        $foods = [];
        $dto = [];

        $this->foodService->method('search')->willReturn($foods);
        $this->foodResponseDtoTransformer->method('transformFromObjects')->willReturn($dto);

        $response = $this->controller->search($request);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testGet(): void
    {
        $request = new Request();
        $food = null;

        $this->foodRepository->method('find')->willReturn($food);

        $response = $this->controller->get($request, 1);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testCreate(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode(['name' => 'apple']));
        $foodEntity = $this->createMock(FoodDtoInterface::class);
        $errors = [];

        $this->foodFactory->method('create')->willReturn($foodEntity);
        $this->validator->method('validate')->willReturn($errors);
        $this->foodRepository->method('save')->willReturn($foodEntity);

        $response = $this->controller->create($request, $this->validator);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testUpdate(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode(['name' => 'apple']));
        $foodEntity = $this->createMock(FoodDtoInterface::class);
        $errors = [];

        $this->foodRepository->method('find')->willReturn($foodEntity);
        $this->foodService->method('updateEntity')->willReturn($foodEntity);
        $this->validator->method('validate')->willReturn($errors);
        $this->foodRepository->method('save')->willReturn($foodEntity);

        $response = $this->controller->update($request, $this->validator, 1);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testDelete(): void
    {
        $foodEntity = $this->createMock(FoodDtoInterface::class);

        $this->foodRepository->method('find')->willReturn($foodEntity);

        $response = $this->controller->delete(1);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}