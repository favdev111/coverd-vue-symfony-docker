<?php

namespace App\Repository\Orders;

use App\Entity\Orders\PartnerOrder;
use App\Repository\OrderRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\ParameterBag;

class PartnerOrderRepository extends OrderRepository
{
    protected function joinRelatedTables(QueryBuilder $qb)
    {
        $qb->leftJoin('o.partner', 'partner')
            ->leftJoin('o.warehouse', 'warehouse');
    }

    /**
     * @param string|null $sortField
     * @param string|null $sortDirection
     * @param ParameterBag|null $params
     * @return PartnerOrder[]
     */
    public function partnerOrderTotals(
        ?string $sortField = null,
        ?string $sortDirection = 'ASC',
        ParameterBag $params = null
    ): array {
        $qb = $this->createQueryBuilder('o')
            ->leftJoin('o.lineItems', 'l')
            ->join('o.partner', 'p');

        if ($sortField && $sortField != 'total') {
            if (strstr($sortField, '.') === false) {
                $sortField = 'o.' . $sortField;
            }
            $qb->orderBy($sortField, $sortDirection);
        }

        $this->addCriteria($qb, $params);

        return $qb->getQuery()->execute();
    }

    public function findPartnerOrderTotalsCount(ParameterBag $params): int
    {

        $qb = $this->createQueryBuilder('o')
            ->select('p.id')
            ->join('o.partner', 'p')
            ->groupBy('p.id');

        $this->addCriteria($qb, $params);

        $paginator = new Paginator($qb->getQuery());
        return $paginator->count();
    }

    protected function addCriteria(QueryBuilder $qb, ParameterBag $params)
    {
        parent::addCriteria($qb, $params);

        if ($params->has('partner')) {
            $qb->andWhere('o.partner = :partner')
                ->setParameter('partner', $params->get('partner'));
        }

        if ($params->has('product')) {
            $qb->andWhere('l.product = :product')
                ->setParameter('product', $params->get('product'));
        }

        if ($params->has('partnerType')) {
            $qb->andWhere('p.partnerType = :partnerType')
                ->setParameter('partnerType', $params->get('partnerType'));
        }

        if ($params->has('orderPeriod')) {
            $qb->andWhere('o.orderPeriod = :orderPeriod')
                ->setParameter('orderPeriod', $params->get('orderPeriod'));
        }

        if ($params->has('startingAt')) {
            $qb->andWhere('o.orderPeriod >= :startingAt')
                ->setParameter('startingAt', new \DateTime($params->get('startingAt')));
        }

        if ($params->has('endingAt')) {
            $qb->andWhere('o.orderPeriod <= :endingAt')
                ->setParameter('endingAt', new \DateTime($params->get('endingAt')));
        }
    }

    public function findOneByMonth(\DateTime $month): PartnerOrder
    {
        return $this->findOneBy(['orderPeriod' => $month]);
    }
}
