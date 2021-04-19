<?php

namespace App\Transformers\Report;

use App\Entity\InventoryTransaction;
use App\Entity\Orders\AdjustmentOrder;
use League\Fractal\TransformerAbstract;

class InventoryTransactionReportTransformer extends TransformerAbstract
{

    public function transform(InventoryTransaction $inventoryTransaction)
    {
        $order = $inventoryTransaction->getLineItem()->getOrder();

        return [
            'id' => (int) $inventoryTransaction->getId(),
            'delta' => (int) $inventoryTransaction->getDelta(),
            'cost' => (float) $inventoryTransaction->getCost(),
            'committedAt' => $inventoryTransaction->getCommittedAt()
                ? $inventoryTransaction->getCommittedAt()->format('c')
                : null,
            'createdAt' => $inventoryTransaction->getCreatedAt()->format('c'),
            'isCommitted' => (bool) $inventoryTransaction->isCommitted(),
            'product' => $inventoryTransaction->getProduct()->getName(),
            'storageLocation' => $inventoryTransaction->getStorageLocation()->getTitle(),
            'order' => $order->getId(),
            'orderType' => $order->getOrderTypeName(),
            'reason' => $order instanceof AdjustmentOrder ? $order->getReason() : null,

        ];
    }
}
