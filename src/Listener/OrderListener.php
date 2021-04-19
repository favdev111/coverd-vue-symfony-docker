<?php

namespace App\Listener;

use App\Entity\Order;
use App\Service\SequenceGenerator;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class OrderListener
{
    public function prePersist(Order $order, LifecycleEventArgs $event)
    {
        $sg = new SequenceGenerator($event->getEntityManager());
        $order->setSequenceNo($sg->generateNext($order));
    }

    public function preUpdate(Order $order, PreUpdateEventArgs $event)
    {
        $order->setUpdatedAt(new \DateTime());
    }

    public function preFlush(Order $order, PreFlushEventArgs $event)
    {
        if ($order->isComplete()) {
            $order->commitTransactions();
            $order->completeOrder();
        }
    }
}
