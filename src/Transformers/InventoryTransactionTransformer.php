<?php

namespace App\Transformers;

use App\Entity\InventoryTransaction;
use League\Fractal\TransformerAbstract;

class InventoryTransactionTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'product',
        'storageLocation',
    ];

    protected $availableIncludes = [
        'lineItem',
    ];


    public function transform(InventoryTransaction $inventoryTransaction)
    {
        return [
            'id' => (int) $inventoryTransaction->getId(),
            'delta' => (int) $inventoryTransaction->getDelta(),
            'cost' => (float) $inventoryTransaction->getCost(),
            'isCommitted' => (bool) $inventoryTransaction->isCommitted(),
        ];
    }

    public function includeLineItem(InventoryTransaction $inventoryTransaction)
    {
        $lineItem = $inventoryTransaction->getLineItem();

        return $this->item($lineItem, new LineItemTransformer());
    }

    public function includeProduct(InventoryTransaction $inventoryTransaction)
    {
        $product = $inventoryTransaction->getProduct();

        return $this->item($product, new ProductTransformer());
    }

    public function includeStorageLocation(InventoryTransaction $inventoryTransaction)
    {
        $storageLocation = $inventoryTransaction->getStorageLocation();

        return $this->item($storageLocation, new StorageLocationTransformer());
    }
}
