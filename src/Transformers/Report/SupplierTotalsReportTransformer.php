<?php

namespace App\Transformers\Report;

use App\Entity\Supplier;
use App\Reports\SupplierTotalsRow;
use League\Fractal\TransformerAbstract;

class SupplierTotalsReportTransformer extends TransformerAbstract
{

    public function transform(SupplierTotalsRow $supplierTotal)
    {
        /** @var Supplier $supplier */
        $supplier = $supplierTotal->getSupplier();
        $total = $supplierTotal->getTotal();

        $result = [
            'id' => (int) $supplier->getId(),
            'name' => $supplier->getTitle(),
            'type' => $supplier->getSupplierType(),
            'total' => $total,
        ];

        $result = $result + $supplierTotal->getProductTotals();

        return $result;
    }
}
