<?php

namespace App\Transformers\Report;

use App\Entity\Partner;
use App\Reports\DistributionTotalsRow;
use League\Fractal\TransformerAbstract;

class DistributionTotalsReportTransformer extends TransformerAbstract
{

    public function transform(DistributionTotalsRow $partnerTotal)
    {
        /** @var Partner $partner */
        $partner = $partnerTotal->getPartner();
        $total = $partnerTotal->getTotal();

        $result = [
            'id' => (int) $partner->getId(),
            'name' => $partner->getTitle(),
            'type' => $partner->getPartnerType(),
            'total' => $total,
        ];

        $result = $result + $partnerTotal->getProductTotals();

        return $result;
    }
}
