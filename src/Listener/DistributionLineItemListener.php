<?php

namespace App\Listener;

use App\Entity\LineItem;
use App\Entity\Orders\BulkDistributionLineItem;
use App\Entity\ProductCategory;
use App\Entity\Setting;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;

class DistributionLineItemListener extends LineItemListener
{
    public function postPersist(BulkDistributionLineItem $line, LifecycleEventArgs $event)
    {
        $count = $this->getPullupCount($line, $event);
        $line->getClient()->setPullupDistributionCount($count);

        $line->getClient()->calculateDistributionExpiration();
        $event->getEntityManager()->flush($line->getClient());
    }

    public function postUpdate(BulkDistributionLineItem $line, LifecycleEventArgs $event)
    {
        $count = $this->getPullupCount($line, $event);
        $line->getClient()->setPullupDistributionCount($count);

        $line->getClient()->calculateDistributionExpiration();
        $event->getEntityManager()->flush($line->getClient());
    }

    /**
     * @param BulkDistributionLineItem $line
     * @param LifecycleEventArgs $event
     * @return BulkDistributionLineItem|mixed
     */
    private function getPullupCount(BulkDistributionLineItem $line, LifecycleEventArgs $event)
    {
        /** @var Setting $categorySetting */
        $categorySetting = $event->getEntityManager()->getRepository(Setting::class)->find('pullupCategory');
        /** @var ProductCategory $category */
        $category = $event
            ->getEntityManager()
            ->getRepository(ProductCategory::class)->find($categorySetting->getValue());
        $clientDistributions = $line->getClient()->getDistributionLineItems();

        $count = array_reduce(
            $clientDistributions->toArray(),
            function ($carry, BulkDistributionLineItem $distribution) use ($category) {
                $change = $distribution->getProduct()->getProductCategory()->getId() == $category->getId() ? 1 : 0;
                return $carry + $change;
            },
            0
        );
        return $count;
    }
}
