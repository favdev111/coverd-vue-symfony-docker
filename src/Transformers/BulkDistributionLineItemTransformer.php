<?php

namespace App\Transformers;

use App\Entity\LineItem;
use App\Entity\Orders\BulkDistributionLineItem;
use League\Fractal\Resource\Item;

class BulkDistributionLineItemTransformer extends LineItemTransformer
{

    public function getDefaultIncludes()
    {
        $includes =  parent::getDefaultIncludes();

        $includes[] = 'client';
        $includes[] = 'product';
        return $includes;
    }

    public function transform(LineItem $lineItem): array
    {
        $properties = parent::transform($lineItem);

        if ($lineItem->getOrder()->getId()) {
            $properties['orderSequence'] = $lineItem->getOrder()->getSequenceNo();
            $properties['orderId'] = $lineItem->getOrder()->getId();
        }

        return $properties;
    }

    public function includeClient(BulkDistributionLineItem $lineItem): Item
    {
        return $this->item($lineItem->getClient(), new ClientTransformer());
    }

    public function includeOrder(LineItem $lineItem): Item
    {
        $order = $lineItem->getOrder();

        return $this->item($order, new BulkDistributionTransformer());
    }
}
