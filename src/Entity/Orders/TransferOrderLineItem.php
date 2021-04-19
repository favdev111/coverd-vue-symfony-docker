<?php

namespace App\Entity\Orders;

use App\Entity\InventoryTransaction;
use App\Entity\LineItem;
use App\Entity\Orders\TransferOrder;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TransferOrderLineItem
 *
 * @ORM\Entity()
 */
class TransferOrderLineItem extends LineItem
{

    /**
     * Transfer Orders generate a deduction from the source and an increase to the target
     */
    public function generateTransactions()
    {
        // Wipe out any existing transactions
        $this->clearTransactions();

        if ($this->getQuantity() <> 0) {
            /** @var TransferOrder $order */
            $order = $this->getOrder();
            $sourceTransaction = new InventoryTransaction($order->getSourceLocation(), $this, 0 - $this->getQuantity());
            $targetTransaction = new InventoryTransaction($order->getTargetLocation(), $this, $this->getQuantity());

            $this->addTransaction($sourceTransaction);
            $this->addTransaction($targetTransaction);
        }
    }

    public function updateTransactions()
    {
        parent::updateTransactions();

        $transactions = $this->getTransactions();

        /** @var TransferOrder $order */
        $order = $this->getOrder();

        foreach ($transactions as $transaction) {
            if ($transaction->getDelta() < 0) {
                $transaction->setStorageLocation($order->getSourceLocation());
                $transaction->setDelta(0 - $this->getQuantity());
            } else {
                $transaction->setStorageLocation($order->getTargetLocation());
                $transaction->setDelta($this->getQuantity());
            }
            $transaction->setCost($this->getCost());
        }
    }
}
