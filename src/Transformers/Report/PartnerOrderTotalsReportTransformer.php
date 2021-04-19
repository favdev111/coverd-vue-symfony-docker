<?php

namespace App\Transformers\Report;

use App\Entity\Partner;
use App\Reports\DistributionTotalsRow;
use App\Reports\PartnerOrderTotalsRow;
use League\Fractal\TransformerAbstract;

class PartnerOrderTotalsReportTransformer extends TransformerAbstract
{

    public function transform(PartnerOrderTotalsRow $partnerTotal)
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
