<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class InventoryTransaction
 *
 * @ORM\Entity(repositoryClass="App\Repository\InventoryTransactionRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class InventoryTransaction extends CoreEntity
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var StorageLocation
     *
     * @ORM\ManyToOne(targetEntity="StorageLocation")
     */
    protected $storageLocation;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    protected $product;

    /**
     * @var LineItem
     *
     * @ORM\ManyToOne(targetEntity="LineItem", inversedBy="transactions" )
     */
    protected $lineItem;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $delta;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $cost;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $committed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $committedAt;

    public function __construct(StorageLocation $storageLocation, LineItem $lineItem, $delta)
    {
        $this->setStorageLocation($storageLocation);
        $this->setLineItem($lineItem);
        $this->setDelta($delta);
        $this->setProduct($lineItem->getProduct());
        $this->setCost($lineItem->getCost());
        $this->committed = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return LineItem
     */
    public function getLineItem()
    {
        return $this->lineItem;
    }

    /**
     * @param LineItem $lineItem
     */
    public function setLineItem(LineItem $lineItem)
    {
        $this->lineItem = $lineItem;
    }

    /**
     * @return StorageLocation
     */
    public function getStorageLocation()
    {
        return $this->storageLocation;
    }

    /**
     * @param StorageLocation $storageLocation
     */
    public function setStorageLocation(StorageLocation $storageLocation)
    {
        $this->storageLocation = $storageLocation;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return bool
     */
    public function isCommitted()
    {
        return $this->committed;
    }

    /**
     * Flags the transaction as committed
     */
    public function commit(\DateTime $committedAt = null)
    {
        $this->committed = true;
        $this->committedAt = $committedAt ?: new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCommittedAt()
    {
        return $this->committedAt ? clone $this->committedAt : null;
    }

    /**
     * @param \DateTime $committedAt
     */
    public function setCommittedAt(\DateTime $committedAt)
    {
        $this->committedAt = $committedAt;
    }
}
