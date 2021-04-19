<?php

namespace App\Helpers;

use App\Entity\Partner;
use App\Entity\Product;

class Pack
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Diapers in pack
     *
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $partnerType;

    public function __construct(Product $product, $partnerType = Partner::TYPE_AGENCY)
    {
        $this->product = $product;
        $this->partnerType = $partnerType;
        $this->quantity = $this->getPackSize();
    }

    public function bagPercent()
    {
        return 1 / $this->getPacksPerBag();
    }

    private function getPackSize()
    {
        if ($this->partnerType === Partner::TYPE_HOSPITAL && $this->product->getHospitalPackSize() > 0) {
            return $this->product->getHospitalPackSize();
        }
        return $this->product->getAgencyPackSize();
    }

    private function getPacksPerBag()
    {
        if ($this->partnerType === Partner::TYPE_HOSPITAL && $this->product->getHospitalPacksPerBag() > 0) {
            return $this->product->getHospitalPacksPerBag();
        }
        return $this->product->getAgencyPacksPerBag();
    }
}
