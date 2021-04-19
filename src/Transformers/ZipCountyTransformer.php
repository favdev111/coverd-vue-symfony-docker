<?php

namespace App\Transformers;

use App\Entity\ZipCounty;
use League\Fractal\TransformerAbstract;

/**
 * Class ZipCountyTransformer
 *
 * Lightweight transformer for populating combo Zip/County fields
 *
 * @package App\Transformers
 */
class ZipCountyTransformer extends TransformerAbstract
{
    public function transform(ZipCounty $zipCounty = null)
    {
        if (!$zipCounty) {
            return [ 'id' => null ];
        }

        return [
            'id' => (int) $zipCounty->getId(),
            'label' => sprintf(
                "%s (%s, %s)",
                $zipCounty->getZipCode(),
                $zipCounty->getCountyName(),
                $zipCounty->getStateCode()
            ),
        ];
    }
}
