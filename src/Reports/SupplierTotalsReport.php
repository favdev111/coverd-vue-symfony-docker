<?php

namespace App\Reports;

use App\Entity\Supplier;
use Doctrine\Common\Collections\ArrayCollection;

class SupplierTotalsReport
{
    /**
     * @var ArrayCollection|SupplierTotalsRow[]
     */
    protected $rows;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    public function getRow(Supplier $supplier)
    {
        $row = $this->rows->filter(function (SupplierTotalsRow $row) use ($supplier) {
            return $row->getSupplier()->getId() == $supplier->getId();
        })->first();

        if (empty($row)) {
            $row = new SupplierTotalsRow($supplier);
            $this->rows->add($row);
        }

        return $row;
    }

    /**
     * @return SupplierTotalsRow[]|ArrayCollection
     */
    public function getRows()
    {
        return $this->rows;
    }
}
