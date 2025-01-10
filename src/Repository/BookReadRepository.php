<?php

namespace App\Repository;

use App\Entity\BookRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookRead>
 */
class BookReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookRead::class);
    }

    /**
     * Method to find all ReadBook entities by user_id
     * @param int $userId
     * @param bool $readState
     * @return array
     */
    public function findByUserId(int $userId, bool $readState): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.user', 'u')
            ->where('u.id = :userId')
            ->andWhere('r.is_read = :isRead')
            ->setParameter('userId', $userId)
            ->setParameter('isRead', $readState)
            ->orderBy('r.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function searchBooksByName($userId, $searchTerm)
    {
        return $this->createQueryBuilder('br')
        ->join('br.book', 'b')
        ->where('br.user = :userId')
        ->andWhere('b.name LIKE :searchTerm')
        ->setParameter('userId', $userId)
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery()
        ->getResult();
    }

    public function searchFinishedBooksByName($userId, $searchTerm)
    {
        return $this->createQueryBuilder('br')
            ->join('br.book', 'b')
            ->where('br.user = :userId')
            ->andWhere('b.name LIKE :searchTerm')
            ->andWhere('br.isFinished = true')
            ->setParameter('userId', $userId)
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }
}
