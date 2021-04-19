<?php

namespace App\Transformers;

use App\Entity\ListOption;
use League\Fractal\TransformerAbstract;

/**
 * Class ListOptionTransformer
 *
 * Lightweight transformer for populating combo option fields
 *
 * @package App\Transformers
 */
class ListOptionTransformer extends TransformerAbstract
{
    public function transform(ListOption $listOption = null)
    {
        if (!$listOption) {
            return [ 'id' => null ];
        }

        return [
            'id' => (int) $listOption->getId(),
            'name' => $listOption->getName(),
            'status' => $listOption->getStatus(),
            'createdAt' => $listOption->getCreatedAt()->format('c'),
            'updatedAt' => $listOption->getUpdatedAt()->format('c'),
        ];
    }
}
