<?php

namespace App\Repository;

use App\Entity\App\Entity\VehiculoUsado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehiculoUsado>
 *
 * @method VehiculoUsado|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculoUsado|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculoUsado[]    findAll()
 * @method VehiculoUsado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculoUsadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiculoUsado::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(VehiculoUsado $entity, bool $flush = true): void
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
    public function remove(VehiculoUsado $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return VehiculoUsado[] Returns an array of VehiculoUsado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehiculoUsado
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
