<?php

namespace App\Transformers;

use App\Entity\Order;
use App\Entity\Orders\AdjustmentOrder;

class AdjustmentOrderTransformer extends OrderTransformer
{

    protected $availableIncludes = [
        'lineItems',
    ];

    protected $defaultIncludes = [
        'storageLocation',
    ];

    /**
     * @param AdjustmentOrder $order
     * @return array
     */
    public function transform(Order $order)
    {
        $properties = parent::transform($order);

        $properties['reason'] = $order->getReason();

        return $properties;
    }


    public function includeStorageLocation(AdjustmentOrder $order)
    {
        $partner = $order->getStorageLocation();

        return $this->item($partner, new StorageLocationTransformer());
    }
}
