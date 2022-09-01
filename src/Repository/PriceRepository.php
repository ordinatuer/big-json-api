<?php

namespace App\Repository;

use App\Entity\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    /**
     * По всему списку
     * Проверка записи по ключу (region_id, product_id)
     * Если нет - добавляем
     * Если есть такая же - не трогаем
     * Если отличаетя - правим
     */
    public function addList(array $data): array
    {
        $manager = $this->getEntityManager();
        $result = [];

        foreach($data as $product) {
            $_result = [
                'product_id' => $product->product_id,
                'prices' => [],
            ];

            foreach($product->prices as $region_id => $prices) {
                // INSERT INTO table ... ON DUPLICATE KEY UPDATE ...
                    // merge is deprecated
                // if ($res = $manager->merge($price)) {
                //     $result++;
                // }

                $row = $manager->find(Price::class, [
                    'region_id' => $region_id,
                    'product_id' => $product->product_id,
                ]);

                if (!$row) {
                    $row = new Price();

                    $row->setRegionId($region_id);
                    $row->setProductId($product->product_id);
                }

                $row->setPrices($prices);

                $manager->persist($row);

                $manager->flush();
                $manager->clear();

                $_result['prices'][$region_id] = [
                    "price_purchase" => $row->getPricePurchase(),
                    "price_selling" => $row->getPriceSelling(),
                    "price_discount" => $row->getPriceDiscount(),
                ];
            }

            $result[] = $_result;
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
