<?php

namespace App\Repository;

use App\Entity\AppBundleVehiculo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppBundleVehiculo>
 *
 * @method AppBundleVehiculo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppBundleVehiculo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppBundleVehiculo[]    findAll()
 * @method AppBundleVehiculo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppBundleVehiculoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppBundleVehiculo::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AppBundleVehiculo $entity, bool $flush = true): void
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
    public function remove(AppBundleVehiculo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return AppBundleVehiculo[] Returns an array of AppBundleVehiculo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppBundleVehiculo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
