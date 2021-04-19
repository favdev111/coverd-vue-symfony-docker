<?php

namespace App\Entity\Orders;

use App\Entity\InventoryTransaction;
use App\Entity\LineItem;
use App\Entity\Orders\AdjustmentOrder;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class AdjustmentOrderLineItem
 *
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class AdjustmentOrderLineItem extends LineItem
{

    /**
     * Adjustment Orders only generate a single transaction to a Storage Location
     */
    public function generateTransactions()
    {
        // Wipe out any existing transactions
        $this->clearTransactions();

        if ($this->getQuantity() <> 0) {
            /** @var AdjustmentOrder $order */
            $order = $this->getOrder();
            $transaction = new InventoryTransaction($order->getStorageLocation(), $this, $this->getQuantity());

            $this->addTransaction($transaction);
        }
    }

    public function updateTransactions()
    {
        parent::updateTransactions();

        $transactions = $this->getTransactions();

        /** @var AdjustmentOrder $order */
        $order = $this->getOrder();

        foreach ($transactions as $transaction) {
            $transaction->setStorageLocation($order->getStorageLocation());
            $transaction->setDelta($this->getQuantity());
            $transaction->setCost($this->getCost());
        }
    }

    protected function validateQuantity()
    {
        // Adjustment lines can have negative quantities
    }
}
