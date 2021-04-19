<?php

namespace App\Transformers;

use App\Entity\Order;
use League\Fractal\TransformerAbstract;

class OrderListTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'lineItems',
    ];


    public function transform(Order $order)
    {
        return [
            'id' => (int) $order->getId(),
            'status' => $order->getStatus(),
        ];
    }

    public function includeLineItems(Order $order)
    {
        $lineItems = $order->getLineItems();
        $transformer = new LineItemTransformer();
        $defaultIncludes = $transformer->getDefaultIncludes();
        $transformer->setDefaultIncludes(array_diff($defaultIncludes, ['order', 'transactions', 'product']));

        return $this->collection($lineItems, $transformer);
    }
}
