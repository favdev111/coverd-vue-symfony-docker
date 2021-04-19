<?php

namespace App\Transformers;

use App\Entity\ListOption;
use App\Entity\ProductCategory;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductCategoryTransformer
 *
 * Lightweight transformer for populating combo option fields
 *
 * @package App\Transformers
 */
class ProductCategoryTransformer extends ListOptionTransformer
{
    public function transform(ListOption $productCategory = null)
    {
        $properties = parent::transform($productCategory);

        $properties['isPartnerOrderable'] = $productCategory->isPartnerOrderable();

        return $properties;
    }
}
