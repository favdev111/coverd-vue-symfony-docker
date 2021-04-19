<?php

namespace App\Reports;

use App\Entity\Product;
use App\Entity\Supplier;

/**
 * Class SupplierTotalsRow
 *
 * Helper class for the Supplier Totals Report that collects the totals for each product.
 *
 * @package App\Helpers
 */
class SupplierTotalsRow
{

    /**
     * @var Supplier
     */
    protected $supplier;

    /**
     * Key = product id
     *
     * @var int[]
     */
    protected $productTotals;

    public function __construct(Supplier $supplier = null)
    {
        $this->productTotals = [];
        $this->setSupplier($supplier);
    }

    /**
     * @return Supplier
     */
    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    /**
     * @param Supplier $supplier
     */
    public function setSupplier(Supplier $supplier): void
    {
        $this->supplier = $supplier;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return array_sum($this->productTotals);
    }

    /**
     * @return int[]
     */
    public function getProductTotals(): array
    {
        return $this->productTotals;
    }

    /**
     * @param Product $product
     * @param integer$add
     */
    public function addProductTotal(Product $product, int $add)
    {
        if (!isset($this->productTotals[$product->getSku()])) {
            $this->productTotals[$product->getSku()] = $add;
        } else {
            $this->productTotals[$product->getSku()] += $add;
        }
    }

    /**
     * @param Product $product
     * @return int|null
     */
    public function getProductTotal(Product $product)
    {
        return $this->productTotals[$product->getSku()] ?? null;
    }
}
