<?php

namespace App\Transformers;

use App\Entity\Order;
use App\Entity\Orders\PartnerOrder;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class PartnerOrderTransformer extends OrderTransformer
{

    protected $availableIncludes = [
        'lineItems',
        'bags'
    ];

    protected $defaultIncludes = [
        'partner',
        'warehouse',
    ];

    /**
     * @param PartnerOrder $order
     * @return array
     */
    public function transform(Order $order)
    {
        $fields = parent::transform($order);

        $fields['orderPeriod'] = $order->getOrderPeriod()->format('c');
        $fields['portalOrderId'] = $order->getPortalOrderId();
        return $fields;
    }

    /**
     * @param PartnerOrder $order
     * @return Collection
     */
    public function includeLineItems(Order $order): Collection
    {
        if ($order->isEditable()) {
            $order->addMissingClients();
        }

        $lineItems = $order->getLineItems();

        return $this->collection($lineItems, new PartnerOrderLineItemTransformer());
    }

    public function includePartner(PartnerOrder $order): Item
    {
        $partner = $order->getPartner();

        return $this->item($partner, new PartnerTransformer());
    }

    public function includeWarehouse(PartnerOrder $order): Item
    {
        $warehouse = $order->getWarehouse();

        return $this->item($warehouse, new StorageLocationTransformer());
    }

    public function includeBags(PartnerOrder $order): Collection
    {
        return $this->collection($order->buildBags(), new BagTransformer());
    }
}
