<?php

namespace App\Repository;

use App\Entity\Joueur;
use App\Entity\Synchro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Joueur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeterSame($userTryhardMeter, $userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter = :val1')
            ->andWhere(':val2 != j.id')
            ->setParameter('val1', $userTryhardMeter)
            ->setParameter('val2', $userId)
            ->orderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeter0_2($userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter between 0 and 2')
            ->andWhere(':val != j.id')
            ->setParameter('val', $userId)
            ->orderBy('j.tryhard_meter', 'ASC')
            ->addOrderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeter2_4($userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter between 2 and 4')
            ->andWhere(':val != j.id')
            ->setParameter('val', $userId)
            ->orderBy('j.tryhard_meter', 'ASC')
            ->addOrderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeter4_6($userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter between 4 and 6')
            ->andWhere(':val != j.id')
            ->setParameter('val', $userId)
            ->orderBy('j.tryhard_meter', 'ASC')
            ->addOrderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeter6_8($userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter between 6 and 8')
            ->andWhere(':val != j.id')
            ->setParameter('val', $userId)
            ->orderBy('j.tryhard_meter', 'ASC')
            ->addOrderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    public function findByTryhardMeter8_10($userId)
    {
        return $this->createQueryBuilder('j')
            ->Where('j.tryhard_meter between 8 and 10')
            ->andWhere(':val != j.id')
            ->setParameter('val', $userId)
            ->orderBy('j.tryhard_meter', 'ASC')
            ->addOrderBy('j.pseudo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Joueur
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
