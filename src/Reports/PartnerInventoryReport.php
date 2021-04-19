<?php

namespace App\Reports;

use App\Entity\Partner;
use Doctrine\Common\Collections\ArrayCollection;

class PartnerInventoryReport
{
    /**
     * @var ArrayCollection|PartnerInventoryRow[]
     */
    protected $rows;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    public function getRow(Partner $partner)
    {
        $row = $this->rows->filter(function (PartnerInventoryRow $row) use ($partner) {
            return $row->getPartner()->getId() == $partner->getId();
        })->first();

        if (empty($row)) {
            $row = new PartnerInventoryRow($partner);
            $this->rows->add($row);
        }

        return $row;
    }

    /**
     * @return PartnerInventoryRow[]|ArrayCollection
     */
    public function getRows()
    {
        return $this->rows;
    }
}
