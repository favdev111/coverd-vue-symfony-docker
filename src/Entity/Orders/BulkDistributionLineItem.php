<?php

namespace App\Entity\Orders;

use App\Entity\Client;
use App\Entity\InventoryTransaction;
use App\Entity\LineItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BulkDistributionLineItem
 *
 * @ORM\Entity(repositoryClass="App\Repository\Orders\BulkDistributionLineItemRepository")
 * @ORM\EntityListeners({"App\Listener\DistributionLineItemListener"})
 */
class BulkDistributionLineItem extends LineItem
{

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="distributionLineItems")
     */
    protected $client;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getDistributionPeriod(): ?\DateTime
    {
        /** @var BulkDistribution $order */
        $order = $this->getOrder();

        return $this->hasOrder() ? $order->getDistributionPeriod() : null;
    }

    /**
     * Partner Orders generate a deduction from the warehouse and an increase to the partner
     */
    public function generateTransactions()
    {
        // Wipe out any existing transactions
        $this->clearTransactions();

        if ($this->getQuantity() <> 0) {
            /** @var BulkDistribution $order */
            $order = $this->getOrder();
            $partnerTransaction = new InventoryTransaction($order->getPartner(), $this, 0 - $this->getQuantity());

            $this->addTransaction($partnerTransaction);
        }
    }

    public function updateTransactions()
    {
        parent::updateTransactions();

        $transactions = $this->getTransactions();

        /** @var BulkDistribution $order */
        $order = $this->getOrder();

        foreach ($transactions as $transaction) {
            $transaction->setStorageLocation($order->getPartner());
            $transaction->setProduct($transaction->getLineItem()->getProduct());
            $transaction->setDelta(0 - $this->getQuantity());
        }
    }
}
