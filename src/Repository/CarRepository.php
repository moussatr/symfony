<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

     /**
        * @return Car[] Returns an array of Car objects
     */
   public function findBysearch(string $text): array
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.name LIKE :val')
           ->setParameter('val', "%$text%")
           ->getQuery()
           ->getResult()
       ;
   }


   public function findBySearchTermAndCategory($searchTerm, $category)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        if (!empty($searchTerm)) {
            $queryBuilder
                ->where('p.name LIKE :searchTerm')
                
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        if (!empty($carCategory)) {
            $queryBuilder
                ->andWhere('p.name = :name')
                ->setParameter('name', $carcategory);
        }

        return $queryBuilder->getQuery()->getResult();
    }

}



