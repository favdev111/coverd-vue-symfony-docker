<?php

namespace App\Entity\Orders;

use App\Entity\InventoryTransaction;
use App\Entity\LineItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MerchandiseOrderLineItem
 *
 * @ORM\Entity()
 */
class MerchandiseOrderLineItem extends LineItem
{

    /**
     * Merchandise Orders only generate a single positive transaction to a warehouse
     */
    public function generateTransactions()
    {
        // Wipe out any existing transactions
        $this->clearTransactions();

        if ($this->getQuantity() <> 0) {
            /** @var MerchandiseOrder $order */
            $order = $this->getOrder();
            $transaction = new InventoryTransaction($order->getWarehouse(), $this, 0 - $this->getQuantity());

            $this->addTransaction($transaction);
        }
    }

    public function updateTransactions()
    {
        parent::updateTransactions();

        $transactions = $this->getTransactions();

        /** @var MerchandiseOrder $order */
        $order = $this->getOrder();

        foreach ($transactions as $transaction) {
            $transaction->setStorageLocation($order->getWarehouse());
            $transaction->setDelta(0 - $this->getQuantity());
            $transaction->setCost($this->getCost());
        }
    }
}
