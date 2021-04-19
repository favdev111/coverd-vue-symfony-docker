<?php

namespace App\Repository\Orders;

use App\Entity\Client;
use App\Entity\Orders\BulkDistribution;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class BulkDistributionLineItemRepository extends EntityRepository
{
    /**
     * @param Client $client
     * @return array|ArrayCollection
     */
    public function getClientDistributionHistory(Client $client)
    {
        $qb = $this->createQueryBuilder('l')
            ->innerJoin(BulkDistribution::class, 'o', Join::WITH, 'l.order = o.id')
            ->andWhere('l.client = :client')
            ->setParameter('client', $client)
            ->orderBy('o.distributionPeriod', 'ASC');

        return $qb->getQuery()->execute();
    }
}
