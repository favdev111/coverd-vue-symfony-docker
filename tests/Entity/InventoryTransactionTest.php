<?php

namespace App\Tests\Entity;

use App\Entity\InventoryTransaction;
use App\Entity\Orders\PartnerOrderLineItem;
use App\Entity\Product;
use App\Entity\Warehouse;
use App\Tests\AbstractWebTestCase;

class InventoryTransactionTest extends AbstractWebTestCase
{
    public function testConstructor()
    {
        $storageLocation      = new Warehouse('Warehouse');
        $product              = new Product('Testing');
        $cost                 = 2;
        $lineItem             = new PartnerOrderLineItem($product, 1, $cost);
        $delta                = 1;
        $inventoryTransaction = new InventoryTransaction($storageLocation, $lineItem, $delta);

        $this->assertSame($product, $inventoryTransaction->getProduct());
        $this->assertSame($cost, $inventoryTransaction->getCost());
        $this->assertFalse($inventoryTransaction->isCommitted());
    }

    public function testCommitSetsTimeAndCommitted()
    {
        $storageLocation      = new Warehouse('Warehouse');
        $product              = new Product('Testing');
        $lineItem             = new PartnerOrderLineItem($product);
        $inventoryTransaction = new InventoryTransaction($storageLocation, $lineItem, 1);

        $inventoryTransaction->commit();

        $this->assertTrue($inventoryTransaction->isCommitted());
        $commitedAt = $inventoryTransaction->getCommittedAt();
        $this->assertLessThanOrEqual(new \DateTime(), $commitedAt);
    }
}
