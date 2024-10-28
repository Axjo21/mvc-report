<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Find book having a matching isbn.
     * 
     * @return Book Returns an array of Book objects
     */
    public function findByIsbn($isbn): Book | null
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.ISBN = :isbn')
        ->setParameter('isbn', $isbn)
        ->getQuery()
        ->getOneOrNullResult();
    }


    # ANPASSA FÖR BOK TABELL
    /**
     * Find all books having a value above the specified one.
     * 
     * @return Book[] Returns an array of Book objects
     */
    public function findByMinimumValue($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.value >= :value')
            ->setParameter('value', $value)
            ->orderBy('p.value', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    # ALTERNATIV TILL OVAN (?)
    /**
     * Find all producs having a value above the specified one with SQL.
     * 
     * #return [][] Returns an array of arrays (i.e. a raw data set)
     */
    /*
    public function findByMinimumValue2($value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM product AS p
            WHERE p.value >= :value
            ORDER BY p.value ASC
        ';

        $resultSet = $conn->executeQuery($sql, ['value' => $value]);

        return $resultSet->fetchAllAssociative();
    }
    */

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
