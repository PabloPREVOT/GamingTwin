<?php

namespace App\Repository;

use App\Entity\Synchro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Synchro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Synchro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Synchro[]    findAll()
 * @method Synchro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SynchroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Synchro::class);
    }

    // /**
    //  * @return Synchro[] Returns an array of Synchro objects
    //  */

    public function findMatchByCurrentUser($currentUserId, $otherPlayerId)
    {
        return $this->createQueryBuilder('s')
            ->where('s.joueur1 = :val1')
            ->andWhere('s.joueur2 = :val2')
            ->setParameter('val1', $currentUserId)
            ->setParameter('val2', $otherPlayerId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMatchByOtherUser($currentUserId, $otherPlayerId)
    {
        return $this->createQueryBuilder('s')
            ->where('s.joueur1 = :val2')
            ->andWhere('s.joueur2 = :val1')
            ->setParameter('val1', $currentUserId)
            ->setParameter('val2', $otherPlayerId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMatchByUser1($currentUserId)
    {
        return $this->createQueryBuilder('s')
            ->where('s.joueur1 = :val')
            ->setParameter('val', $currentUserId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMatchByUser2($currentUserId)
    {
        return $this->createQueryBuilder('s')
            ->where('s.joueur2 = :val')
            ->setParameter('val', $currentUserId)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Synchro
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
