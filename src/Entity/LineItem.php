<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Order
 *
 * @ORM\Entity()
 * @ORM\EntityListeners({"App\Listener\LineItemListener"})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable()
 */
abstract class LineItem extends CoreEntity
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
     * @var Order|null
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="lineItems")
     */
    protected $order;

    /**
     * @var ArrayCollection|InventoryTransaction[]
     *
     * @ORM\OneToMany(
     *     targetEntity="InventoryTransaction",
     *     mappedBy="lineItem",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    protected $transactions;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    protected $product;

    /**
     * @var int
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", nullable=true)
     */
    protected $cost;

    public function __construct(Product $product = null, $quantity = null, $cost = null)
    {
        $this->transactions = new ArrayCollection();

        if ($product) {
            $this->setProduct($product);
        }
        if ($quantity) {
            $this->setQuantity($quantity);
        }
        if ($cost) {
            $this->setCost($cost);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Order
     * @throws \Exception
     */
    public function getOrder(): Order
    {
        if (is_null($this->order)) {
            throw new \Exception(
                'getOrder should not be called when there is a chance it is null. Use hasOrder() to test for this.'
            );
        }

        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function hasOrder(): bool
    {
        return !is_null($this->order);
    }

    /**
     * @return InventoryTransaction[]|ArrayCollection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    public function addTransaction(InventoryTransaction $transaction)
    {
        $this->transactions->add($transaction);
        $transaction->setLineItem($this);
    }

    public function removeTransaction(InventoryTransaction $transaction)
    {
        $found = $this->transactions->filter(function (InventoryTransaction $element) use ($transaction) {
            return $element->getId() == $transaction->getId();
        })->first();

        if ($found) {
            $this->transactions->remove($found);
        }
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        $this->validateQuantity();
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

        $this->validateCost();
    }

    /**
     * Returns true if the line item has transactions that are committed
     *
     * @return bool
     */
    public function hasCommittedTransactions()
    {
        $committedTransactions = $this->getTransactions()->filter(function (InventoryTransaction $transaction) {
            return $transaction->isCommitted();
        });
        return !$committedTransactions->isEmpty();
    }

    public function commitTransactions(\DateTime $commitTime = null)
    {
        foreach ($this->getTransactions() as $transaction) {
            $transaction->commit($commitTime);
        }
    }

    /**
     * @throws \Exception
     */
    protected function clearTransactions()
    {
        if ($this->hasCommittedTransactions()) {
            throw new \Exception('Line Item has committed transactions, cannot clear.');
        }
        $this->getTransactions()->clear();
    }

    protected function validateQuantity()
    {
        if ($this->getQuantity() < 0) {
            throw new \Exception('Line Item must have a positive quantity');
        }
    }

    protected function validateCost()
    {
        if ($this->getCost() < 0) {
            throw new \Exception('Line Item must have a positive cost');
        }
    }

    /**
     * Create the transaction(s) relevant to this line item type
     *
     * @return void
     */
    abstract public function generateTransactions();

    /**
     * Update the transaction(s) relevant to this line item type
     *
     * @return void
     */
    public function updateTransactions()
    {
        if ($this->getTransactions()->isEmpty()) {
            $this->generateTransactions();
        }

        // If the line item has a 0 quantity we should remove the transactions
        if ($this->getQuantity() == 0) {
            $this->clearTransactions();
        }

        if ($this->getOrder()->isComplete()) {
            $this->commitTransactions();
        }
    }
}
