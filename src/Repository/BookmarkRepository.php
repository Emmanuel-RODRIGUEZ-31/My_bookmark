<?php

namespace App\Repository;

use App\Entity\Bookmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    public function findLikeName(string $name, int $user)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->andWhere('p.user = :user')
            ->andWhere('p.status = :status')
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('user', $user)
            ->setParameter('status', Bookmark::STATUS_ON_GOING)
            ->orderBy('p.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Bookmark
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
