<?php

namespace App\Transformers;

use App\Entity\Supplier;
use League\Fractal\TransformerAbstract;

/**
 * Class WarehouseOptionTransformer
 *
 * Lightweight transformer for populating combo option fields
 *
 * @package App\Transformers
 */
class SupplierOptionTransformer extends TransformerAbstract
{
    public function transform(Supplier $supplier)
    {
        return [
            'id' => (int) $supplier->getId(),
            'title' => $supplier->getTitle(),
            'status' => $supplier->getStatus(),
            'supplierType' => $supplier->getSupplierType(),
        ];
    }
}
