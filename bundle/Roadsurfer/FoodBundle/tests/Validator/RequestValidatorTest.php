<?php

namespace Roadsurfer\FoodBundle\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Validator\RequestValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestValidatorTest extends TestCase
{
    private RequestValidator $requestValidator;

    protected function setUp(): void
    {
        $validator = Validation::createValidator();
        $this->requestValidator = new RequestValidator($validator);
    }

    public function testValidateValidData()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => FoodType::Fruit,
                'quantity' => 10,
                'unit' => UnitType::Kilogram
            ]
        ];

        $this->requestValidator->validate($data);

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    public function testValidateInvalidData()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('ID is required');

        $data = [
            [
                'name' => 'Apple',
                'type' => FoodType::Fruit,
                'quantity' => 10,
                'unit' => UnitType::Kilogram
            ]
        ];

        $this->requestValidator->validate($data);
    }

    public function testValidateInvalidType()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Type must be either "fruit" or "vegetable"');

        $data = [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => 'meat',
                'quantity' => 10,
                'unit' => UnitType::Kilogram
            ]
        ];

        $this->requestValidator->validate($data);
    }

    public function testValidateInvalidUnit()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Unit must be either "g" or "kg"');

        $data = [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => FoodType::Fruit,
                'quantity' => 10,
                'unit' => 'lb'
            ]
        ];

        $this->requestValidator->validate($data);
    }

    public function testValidateNegativeQuantity()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Quantity must be a positive number');

        $data = [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => FoodType::Fruit,
                'quantity' => -10,
                'unit' => UnitType::Kilogram
            ]
        ];

        $this->requestValidator->validate($data);
    }
}