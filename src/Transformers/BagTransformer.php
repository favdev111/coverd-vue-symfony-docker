<?php

namespace App\Transformers;

use App\Helpers\Bag;
use League\Fractal\TransformerAbstract;

/**
 * Class BagTransformer
 *
 * Lightweight transformer for bags with pack counts
 *
 * @package App\Transformers
 */
class BagTransformer extends TransformerAbstract
{
    public function transform(Bag $bag)
    {
        return [
            'packCounts' => $bag->getPackCount(),
            'totalPacks' => count($bag->packs),
        ];
    }
}
