<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Validator;

use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate the incoming request data.
     *
     * @param array $data
     * @return void
     */
    public function validate(array $data): void
    {
        foreach ($data as $item) {
            $constraints = $this->getConstraints();
            $violations = $this->validator->validate($item, $constraints);

            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[] = $violation->getPropertyPath() . ' ' . $violation->getMessage();
                }
                throw new BadRequestHttpException(implode(', ', $errors));
            }
        }
    }

    /**
     * Define validation constraints for the collection items.
     *
     * @return Assert\Collection
     */
    private function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => new Assert\NotBlank(['message' => 'ID is required']),
            'name' => new Assert\NotBlank(['message' => 'Name is required']),
            'type' => new Assert\Choice([
                'choices' => [FoodType::Fruit, FoodType::Vegetable],
                'message' => 'Type must be either "fruit" or "vegetable"',
            ]),
            'quantity' => new Assert\Positive(['message' => 'Quantity must be a positive number']),
            'unit' => new Assert\Choice([
                'choices' => [UnitType::Gram, UnitType::Kilogram],
                'message' => 'Unit must be either "g" or "kg"',
            ]),
        ]);
    }
}
