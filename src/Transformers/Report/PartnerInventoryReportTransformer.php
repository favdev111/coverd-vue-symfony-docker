<?php

namespace App\Transformers\Report;

use App\Entity\Partner;
use App\Reports\PartnerInventoryRow;
use League\Fractal\TransformerAbstract;

class PartnerInventoryReportTransformer extends TransformerAbstract
{

    public function transform(PartnerInventoryRow $partnerTotal)
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

        $result = $result + $partnerTotal->getProductInventory() + $partnerTotal->getProductForecasts();

        return $result;
    }
}
