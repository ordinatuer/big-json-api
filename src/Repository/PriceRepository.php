<?php

namespace App\Repository;

use App\Entity\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Price\JSONPrices;

/**
 * @extends ServiceEntityRepository<Price>
 *
 * @method Price|null find($id, $lockMode = null, $lockVersion = null)
 * @method Price|null findOneBy(array $criteria, array $orderBy = null)
 * @method Price[]    findAll()
 * @method Price[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Price::class);
    }

    public function add(Price $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Price $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addList(array $data): int
    {
        $manager = $this->getEntityManager();
        $result = 0;

        foreach($data as $product) {
            foreach($product->prices as $region_id => $prices) {
                $price = new Price();

                $price->setRegionId($region_id);
                $price->setProductId($product->product_id);
                $price->setPrices($prices);

                // INSERT INTO table ... ON DUPLICATE KEY UPDATE ...
                if ($manager->merge($price)) {
                    $result++;
                }

                $manager->flush();
                $manager->clear();
            }
        }

        return $result;
    }

//    /**
//     * @return Price[] Returns an array of Price objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Price
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
