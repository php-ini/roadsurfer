<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Controller\Api;

use Roadsurfer\FoodBundle\Enum\UnitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Roadsurfer\FoodBundle\Service\FoodService;
use Roadsurfer\FoodBundle\Factory\FoodFactory;
use Symfony\Component\Routing\Annotation\Route;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Roadsurfer\FoodBundle\Dto\Response\Transformer\FoodResponseDtoTransformer;

class FoodApiController extends AbstractApiController
{
    const VERSION = 1;
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const NOT_FOUND_MESSAGE = 'Food not found!';

    public function __construct(
        private readonly FoodRepository $foodRepository,
        private readonly FoodResponseDtoTransformer $foodResponseDtoTransformer,
        private readonly FoodFactory $foodFactory,
        private readonly FoodService $foodService,
    )
    {
    }

    #[Route('/api/v1/foods', methods: ['GET'], name: 'roadsurfer_api_get_all_foods')]
    public function all(Request $request): Response
    {
        $foods = $this->foodRepository->findAll();

        $unit = UnitType::tryFrom($request->query->get('unit', UnitType::Gram->value));

        $dto = $this->foodResponseDtoTransformer->transformFromObjects($foods, $unit);

        return $this->respond($dto);
    }

    #[Route('/api/v' . self::VERSION . '/foods/search', methods: ['GET'], name: 'roadsurfer_api_search_foods')]
    public function search(Request $request): Response
    {
        $name = $request->query->get('name');
        $type = $request->query->get('type');
        $unit = UnitType::tryFrom($request->query->get('unit', UnitType::Gram->value));
        $minQuantity = (int)$request->query->get('min_quantity', 0);
        $maxQuantity = (int)$request->query->get('max_quantity', 1000);

        $foods = $this->foodService->search($name, $type, $unit, $minQuantity, $maxQuantity);

        if (empty($foods)) {
            return $this->respond([
                'status' => self::STATUS_FAILED,
                'errors' => 'No food found matching the criteria',
            ], Response::HTTP_NOT_FOUND);
        }

        $dto = $this->foodResponseDtoTransformer->transformFromObjects($foods, $unit);

        return $this->respond($dto);
    }

    #[Route('/api/v' . self::VERSION . '/foods/{id}', methods: ['GET'], name: 'roadsurfer_api_get_foods')]
    public function get(Request $request, int $id): Response
    {
        $food = $this->foodRepository->find($id);

        if (!$food) {
            $data = [
                'status' => self::STATUS_FAILED,
                'errors' => self::NOT_FOUND_MESSAGE,
            ];

            return $this->respond($data, Response::HTTP_NOT_FOUND);
        }

        $unit = UnitType::tryFrom($request->query->get('unit', UnitType::Gram->value));

        $foodDto = $this->foodResponseDtoTransformer->transformFromObject($food, $unit);

        return $this->respond($foodDto);
    }

    #[Route('/api/v' . self::VERSION . '/foods', methods: ['POST'], name: 'roadsurfer_api_create_foods', requirements: ['id' => '\d+'])]
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        try {
            $data = $request->toArray();

            if (!$request || !array_key_exists('name', $data)) {
                throw new \Exception();
            }

            $foodEntity = $this->foodFactory->create($data);

            $errors = $validator->validate($foodEntity);

            if (count($errors) === 0) {

                $foodEntity = $this->foodRepository->save($foodEntity, true);

                return $this->respond($foodEntity->toArray(), Response::HTTP_CREATED);
            }

            return $this->respond(['error' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {
            $data = [
                'status' => self::STATUS_FAILED,
                'errors' => $e->getMessage(),
            ];

            return $this->respond($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    #[Route('/api/v' . self::VERSION . '/foods/{id}', methods: ['PUT'], name: 'roadsurfer_api_update_foods')]
    public function update(Request $request, ValidatorInterface $validator, int $id): Response
    {
        $foods = $this->foodRepository->find($id);

        if (!$foods) {
            $data = [
                'status' => self::STATUS_FAILED,
                'errors' => self::NOT_FOUND_MESSAGE,
            ];

            return $this->respond($data, Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $request->toArray();

            if (!$request || !array_key_exists('name', $data)) {
                throw new \Exception();
            }

            $foodEntity = $this->foodService->updateEntity($foods, $data);

            $errors = $validator->validate($foodEntity);

            if (count($errors) === 0) {
                $foodEntity = $this->foodRepository->save($foodEntity);

                return $this->respond($foodEntity->toArray());
            }

            return $this->respond(['error' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {
            $data = [
                'status' => self::STATUS_FAILED,
                'errors' => $e->getMessage(),
            ];

            return $this->respond($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    #[Route('/api/v' . self::VERSION . '/foods/{id}', methods: ['DELETE'], name: 'roadsurfer_api_delete_foods')]
    public function delete($id): Response
    {
        $food = $this->foodRepository->find($id);

        if (!$food) {
            $data = [
                'status' => self::STATUS_FAILED,
                'errors' => self::NOT_FOUND_MESSAGE,
            ];

            return $this->respond($data, Response::HTTP_NOT_FOUND);
        }

        $this->foodRepository->remove($food, true);

        return $this->respond(null, Response::HTTP_NO_CONTENT);
    }
}