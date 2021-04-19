<?php

namespace App\Listener;

use App\Entity\EAV\Attribute;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class AttributeListener
{
    public function preUpdate(Attribute $attribute, PreUpdateEventArgs $event)
    {
        if (!$attribute->getValue()) {
            $event->getEntityManager()->getUnitOfWork()->remove($attribute);
        }
    }

    public function prePersist(Attribute $attribute, LifecycleEventArgs $event)
    {
        if (!$attribute->getValue()) {
            $event->getEntityManager()->getUnitOfWork()->remove($attribute);
        }
    }
}
