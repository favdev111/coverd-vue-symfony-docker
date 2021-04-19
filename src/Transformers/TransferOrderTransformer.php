<?php

namespace App\Transformers;

use App\Entity\Orders\TransferOrder;

class TransferOrderTransformer extends OrderTransformer
{

    protected $availableIncludes = [
        'lineItems',
    ];

    protected $defaultIncludes = [
        'sourceLocation',
        'targetLocation',
    ];

    public function includeSourceLocation(TransferOrder $order)
    {
        $sourceLocation = $order->getSourceLocation();

        return $this->item($sourceLocation, new StorageLocationTransformer());
    }

    public function includeTargetLocation(TransferOrder $order)
    {
        $targetLocation = $order->getTargetLocation();

        return $this->item($targetLocation, new StorageLocationTransformer());
    }
}
