<?php

namespace App\Reports;

use App\Entity\Partner;
use Doctrine\Common\Collections\ArrayCollection;

class PartnerOrderTotalsReport
{
    /**
     * @var ArrayCollection|PartnerOrderTotalsRow[]
     */
    protected $rows;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    public function getRow(Partner $partner)
    {
        $row = $this->rows->filter(function (PartnerOrderTotalsRow $row) use ($partner) {
            return $row->getPartner()->getId() == $partner->getId();
        })->first();

        if (empty($row)) {
            $row = new PartnerOrderTotalsRow($partner);
            $this->rows->add($row);
        }

        return $row;
    }

    /**
     * @return DistributionTotalsRow[]|ArrayCollection
     */
    public function getRows()
    {
        return $this->rows;
    }
}
