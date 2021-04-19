<?php

namespace App\Reports;

use App\Entity\Product;
use App\Entity\Partner;

/**
 * Class PartnerTotalsRow
 *
 * Helper class for the Partner Totals Report that collects the totals for each product.
 *
 * @package App\Helpers
 */
class PartnerOrderTotalsRow
{

    /**
     * @var Partner
     */
    protected $partner;

    /**
     * Key = product id
     *
     * @var int[]
     */
    protected $productTotals;

    public function __construct(Partner $partner = null)
    {
        $this->productTotals = [];
        $this->setPartner($partner);
    }

    /**
     * @return Partner
     */
    public function getPartner(): Partner
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     */
    public function setPartner(Partner $partner): void
    {
        $this->partner = $partner;
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
