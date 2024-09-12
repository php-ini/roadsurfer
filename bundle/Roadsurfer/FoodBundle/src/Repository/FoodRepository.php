<?php

namespace Roadsurfer\FoodBundle\Repository;

use Roadsurfer\FoodBundle\Entity\Food;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Food>
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);
    }

    public function save(Food $entity, $flush = true): Food
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    public function remove(Food $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(
        ?string $name,
        ?string $type,
        ?int    $minQuantity,
        ?int    $maxQuantity
    ): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($name) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($type) {
            $qb->andWhere('f.type = :type')
                ->setParameter('type', $type);
        }

        if ($minQuantity) {
            $qb->andWhere('f.quantity >= :minQuantity')
                ->setParameter('minQuantity', $minQuantity);
        }

        if ($maxQuantity) {
            $qb->andWhere('f.quantity <= :maxQuantity')
                ->setParameter('maxQuantity', $maxQuantity);
        }

        return $qb->getQuery()->getResult();
    }
}
