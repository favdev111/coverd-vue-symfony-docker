<?php

namespace App\Transformers;

use App\Entity\Orders\MerchandiseOrder;

class MerchandiseOrderTransformer extends OrderTransformer
{

    protected $availableIncludes = [
        'lineItems',
    ];

    protected $defaultIncludes = [
        'warehouse',
    ];

    public function includeWarehouse(MerchandiseOrder $order)
    {
        $warehouse = $order->getWarehouse();

        return $this->item($warehouse, new StorageLocationTransformer());
    }
}
