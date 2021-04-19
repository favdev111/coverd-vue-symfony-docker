<?php

namespace App\Reports;

use App\Entity\Orders\BulkDistribution;
use App\Entity\Partner;
use App\Entity\Product;

/**
 * Class PartnerTotalsRow
 *
 * Helper class for the Partner Totals Report that collects the totals for each product.
 *
 * @package App\Helpers
 */
class PartnerInventoryRow
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
    protected $productInventory;

    /**
     * Key = product id
     *
     * @var int[]
     */
    protected $productForecast;

    /**
     * @var BulkDistribution[]
     */
    protected $forecastDistributions;

    public function __construct(Partner $partner = null)
    {
        $this->productInventory = [];
        $this->productForecast = [];
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
        return array_sum($this->productInventory);
    }

    /**
     * @return int[]
     */
    public function getProductInventory(): array
    {
        return $this->productInventory;
    }

    /**
     * @param Product $product
     * @param integer $inventory
     */
    public function setProductInventory(Product $product, int $inventory)
    {
        $this->productInventory[$product->getSku()] = $inventory;
    }

    /**
     * @return int[]
     */
    public function getProductForecasts(): array
    {
        if (!empty($this->productForecast)) {
            return $this->productForecast;
        }

        $distributionOrderCount = count($this->forecastDistributions);

        foreach ($this->forecastDistributions as $distribution) {
            foreach ($distribution->getLineItems() as $lineItem) {
                $product = $lineItem->getProduct();
                if (!key_exists($product->getSku(), $this->productForecast)) {
                    $this->productForecast[$product->getSku()] = 0;
                }

                $this->productForecast[$product->getSku()] += $lineItem->getQuantity();
            }
        }

        $inventory = $this->productInventory;

        foreach ($this->productForecast as $key => $item) {
            $forecastKey = "forecast-" . $key;
            if (!isset($inventory[$key])) {
                $inventory[$key] = 0;
            }
            $this->productForecast[$forecastKey] = $inventory[$key] / $item / $distributionOrderCount;
        }

        return $this->productForecast;
    }

    /**
     * @param Product $product
     * @param integer $forecast
     */
    public function setForecastDistributions($distributions)
    {
        $this->forecastDistributions = $distributions;
    }

    /**
     * @param Product $product
     * @return int|null
     */
    public function getProductTotal(Product $product)
    {
        return $this->productInventory[$product->getSku()] ?? null;
    }

    /**
     * @param Product $product
     * @return int|null
     */
    public function getProductForecast(Product $product)
    {
        $forecasts = $this->getProductForecasts();
        return $forecasts["forecast-" . $product->getSku()] ?? null;
    }
}
