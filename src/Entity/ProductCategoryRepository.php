<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class ProductCategoryRepository extends EntityRepository
{
    public function isCategoryEmpty(ProductCategory $productCategory): bool
    {
        $productCount = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('count(p)')
            ->from(Product::class, 'p')
            ->andWhere('p.productCategory = :productCategory')
            ->setParameter('productCategory', $productCategory)
            ->getQuery()
            ->getSingleScalarResult();

        return $productCount === 0;
    }
}
