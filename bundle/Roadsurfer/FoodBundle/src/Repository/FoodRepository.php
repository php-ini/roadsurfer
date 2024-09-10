<?php

namespace Roadsurfer\FoodBundle\Repository;

use Roadsurfer\FoodBundle\Entity\Food;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Roadsurfer\FoodBundle\Enum\UnitType;

/**
 * @extends ServiceEntityRepository<Food>
 */
class FoodRepository extends ServiceEntityRepository implements FoodRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);
    }

    //    /**
    //     * @return Food[] Returns an array of Food objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Food
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function save(Food $entity, $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
        ?int $minQuantity,
        ?int $maxQuantity
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
