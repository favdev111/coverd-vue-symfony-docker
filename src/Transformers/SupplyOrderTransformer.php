<?php

namespace App\Transformers;

use App\Entity\Order;
use App\Entity\Orders\SupplyOrder;

class SupplyOrderTransformer extends OrderTransformer
{

    protected $availableIncludes = [
        'lineItems',
        'supplierAddress'
    ];

    protected $defaultIncludes = [
        'warehouse',
        'supplier',
    ];

    /**
     * @param SupplyOrder $order
     * @return array
     */
    public function transform(Order $order)
    {
        $fields = parent::transform($order);

        $fields['receivedAt'] = $order->getReceivedAt() ? $order->getReceivedAt()->format('c') : null;
        return $fields;
    }

    public function includeSupplier(SupplyOrder $order)
    {
        $supplier = $order->getSupplier();

        return $this->item($supplier, new SupplierTransformer());
    }

    public function includeSupplierAddress(SupplyOrder $order)
    {
        $supplierAddress = $order->getSupplierAddress();

        if ($supplierAddress) {
            return $this->item($supplierAddress, new SupplierAddressTransformer());
        }
    }

    public function includeWarehouse(SupplyOrder $order)
    {
        $warehouse = $order->getWarehouse();

        return $this->item($warehouse, new StorageLocationTransformer());
    }
}
