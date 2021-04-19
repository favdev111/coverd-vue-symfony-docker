<?php

namespace App\Transformers;

use App\Entity\LineItem;
use App\Entity\Orders\PartnerOrderLineItem;
use League\Fractal\Resource\Item;

class PartnerOrderLineItemTransformer extends LineItemTransformer
{

    public function getDefaultIncludes(): array
    {
        $includes =  parent::getDefaultIncludes();

        $includes[] = 'client';
        $includes[] = 'product';
        return $includes;
    }

    public function transform(LineItem $lineItem): array
    {
        $properties = parent::transform($lineItem);

        if ($lineItem->hasOrder()) {
            $properties['orderSequence'] = $lineItem->getOrder()->getSequenceNo();
            $properties['orderId'] = $lineItem->getOrder()->getId();
        }

        return $properties;
    }

    public function includeClient(PartnerOrderLineItem $lineItem): ?Item
    {
        if ($lineItem->isClientLineItem()) {
            return $this->item($lineItem->getClient(), new ClientTransformer());
        }
        return null;
    }

    public function includeOrder(LineItem $lineItem): Item
    {
        $order = $lineItem->getOrder();

        return $this->item($order, new BulkDistributionTransformer());
    }
}
