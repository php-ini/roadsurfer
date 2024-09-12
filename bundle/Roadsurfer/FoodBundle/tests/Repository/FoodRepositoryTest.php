<?php

namespace Roadsurfer\FoodBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Roadsurfer\FoodBundle\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FoodRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private FoodRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(Food::class);

        // Create schema
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema([$this->entityManager->getClassMetadata(Food::class)]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    public function testSave()
    {
        $food = new Food();
        $food->setName('Apple');
        $food->setType(FoodType::Fruit);
        $food->setQuantity(1000);
        $food->setUnit(UnitType::Gram);
        $food->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($food);

        $savedFood = $this->repository->find($food->getId());

        $this->assertNotNull($savedFood);
        $this->assertEquals('Apple', $savedFood->getName());
    }

    public function testRemove()
    {
        $food = new Food();
        $food->setName('Apple');
        $food->setType(FoodType::Fruit);
        $food->setQuantity(1000);
        $food->setUnit(UnitType::Gram);
        $food->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($food);
        $this->repository->remove($food, true);

        $removedFood = $this->repository->find($food->getId());

        $this->assertNull($removedFood);
    }

    public function testSearch()
    {
        $food1 = new Food();
        $food1->setName('Apple');
        $food1->setType(FoodType::Fruit);
        $food1->setQuantity(1000);
        $food1->setUnit(UnitType::Gram);
        $food1->setCreatedAt(new \DateTimeImmutable());

        $food2 = new Food();
        $food2->setName('Carrot');
        $food2->setType(FoodType::Vegetable);
        $food2->setQuantity(500);
        $food2->setUnit(UnitType::Gram);
        $food2->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($food1);
        $this->repository->save($food2);

        $results = $this->repository->search('Apple', null, null, null);

        $this->assertCount(1, $results);
        $this->assertEquals('Apple', $results[0]->getName());
    }
}