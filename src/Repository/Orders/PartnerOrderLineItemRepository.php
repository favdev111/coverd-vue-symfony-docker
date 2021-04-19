<?php

namespace App\Repository\Orders;

use Doctrine\ORM\EntityRepository;
use Moment\Moment;
use Symfony\Component\HttpFoundation\ParameterBag;

class PartnerOrderLineItemRepository extends EntityRepository
{

    public function getOrderProductTotals(ParameterBag $params)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('p.id, p.name, c.name, SUM(l.quantity)')
            ->join('l.product', 'p')
            ->join('p.productCategory', 'c')
            ->join('l.order', 'o')
            ->groupBy('p.id');

        $twoMonthsAgoPeriod = new Moment();
        $twoMonthsAgoPeriod->startOf('month')->subtractMonths(2);
        $qb->andWhere('o.orderPeriod = :twoMonthsAgoPeriod')
            ->setParameter('twoMonthsAgoPeriod', $twoMonthsAgoPeriod);


        if ($params->has('month')) {
        }

        return $qb->getQuery()->execute();
    }
}
