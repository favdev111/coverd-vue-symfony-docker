<?php

namespace App\Transformers;

use App\Entity\LineItem;
use League\Fractal\TransformerAbstract;

class LineItemTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'transactions',
        'product',
        'order',
    ];


    public function transform(LineItem $lineItem)
    {
        return [
            'id' => (int) $lineItem->getId(),
            'quantity' => (int) $lineItem->getQuantity(),
            'cost' => (float) $lineItem->getCost(),
            'product' => ['id' => null],
        ];
    }

    public function includeTransactions(LineItem $lineItem)
    {
        $transactions = $lineItem->getTransactions();

        return $this->collection($transactions, new InventoryTransactionTransformer());
    }

    public function includeProduct(LineItem $lineItem)
    {
        $product = $lineItem->getProduct();

        return $product ? $this->item($product, new ProductTransformer()) : null;
    }

    public function includeOrder(LineItem $lineItem)
    {
        $order = $lineItem->getOrder();

        return $this->item($order, new OrderTransformer());
    }
}
