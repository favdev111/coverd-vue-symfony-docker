<?php

namespace App\Listener;

use App\Entity\LineItem;
use Doctrine\ORM\Event\PreFlushEventArgs;

class LineItemListener
{
    public function preFlush(LineItem $lineItem, PreFlushEventArgs $event)
    {
        if ($lineItem->getQuantity() <> 0) {
            $lineItem->updateTransactions();
        } else {
            return false;
        }
    }
}
