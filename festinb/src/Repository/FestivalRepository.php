<?php

namespace App\Repository;

use App\Entity\Festival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Festival|null find($id, $lockMode = null, $lockVersion = null)
 * @method Festival|null findOneBy(array $criteria, array $orderBy = null)
 * @method Festival[]    findAll()
 * @method Festival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Festival $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Festival $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByBetweenDate(array $filters)
    {
        $qb = $this->createQueryBuilder('f');

        foreach ($filters as $key => $value) {
            if ($key === 'begin_at') {
                $qb->andWhere('f.beginAt >= :begin_at')->setParameter('begin_at', $value);
            } elseif ($key === 'end_at') {
                $qb->andWhere('f.endAt <= :end_at')->setParameter('end_at', $value);
            } else {
                $qb->andWhere('f.' . $key . '= :' . $key)->setParameter($key, $value);
            }
        }

        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return FestivalFixtures[] Returns an array of FestivalFixtures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FestivalFixtures
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
