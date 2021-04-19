<?php

namespace App\Helpers;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Bag
 *
 * Used for the fill sheets
 *
 * @package App\Domain\Helpers
 */
class Bag
{
    /**
     * @var ArrayCollection|Pack[]
     */
    public $packs;

    /**
     * @var float
     */
    public $percentFull;

    public function __construct()
    {
        $this->packs = new ArrayCollection();
        $this->percentFull = 0;
    }

    public function addPack(Pack $pack)
    {
        // If adding this pack would put us over the top, return false
        if ($pack->bagPercent() + $this->percentFull > 1) {
            return false;
        }
        $this->packs->add($pack);
        $this->updatePercentFull();
        return true;
    }

    private function updatePercentFull()
    {
        $this->percentFull = array_reduce($this->packs->toArray(), function ($carry, Pack $pack) {
            return $carry + $pack->bagPercent();
        }, 0);
    }

    public function isFull()
    {
        return $this->percentFull == 1;
    }

    public function isEmpty()
    {
        return $this->percentFull != 1;
    }

    public function getPackCount()
    {
        $counts = [];

        foreach ($this->packs as $pack) {
            if (isset($counts[$pack->product->getName()])) {
                $counts[$pack->product->getName()] += 1;
            } else {
                $counts[$pack->product->getName()] = 1;
            }
        }

        return $counts;
    }
}
