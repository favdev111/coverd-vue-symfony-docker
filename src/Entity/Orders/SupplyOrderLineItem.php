<?php

namespace App\Entity\Orders;

use App\Entity\InventoryTransaction;
use App\Entity\LineItem;
use App\Entity\Orders\SupplyOrder;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SupplyOrderLineItem
 *
 * @ORM\Entity()
 */
class SupplyOrderLineItem extends LineItem
{

    /**
     * Supply Orders only generate a single positive transaction to a warehouse
     */
    public function generateTransactions()
    {
        // Wipe out any existing transactions
        $this->clearTransactions();

        // Don't actually create the transactions unless the order is complete.
        // This is so stock levels report makes sense.
        if ($this->getQuantity() <> 0 && $this->getOrder()->isComplete()) {
            /** @var SupplyOrder $order */
            $order = $this->getOrder();
            $transaction = new InventoryTransaction($order->getWarehouse(), $this, $this->getQuantity());

            $this->addTransaction($transaction);
        }
    }

    public function updateTransactions()
    {
        parent::updateTransactions();

        $transactions = $this->getTransactions();

        /** @var SupplyOrder $order */
        $order = $this->getOrder();

        foreach ($transactions as $transaction) {
            $transaction->setStorageLocation($order->getWarehouse());
            $transaction->setDelta($this->getQuantity());
            $transaction->setCost($this->getCost());
        }
    }
}
