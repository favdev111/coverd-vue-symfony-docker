<?php

namespace App\Transformers;

use App\Entity\StorageLocation;
use League\Fractal\TransformerAbstract;

/**
 * Class WarehouseOptionTransformer
 *
 * Lightweight transformer for populating combo option fields
 *
 * @package App\Transformers
 */
class StorageLocationOptionTransformer extends TransformerAbstract
{
    public function transform(StorageLocation $storageLocation)
    {
        $classpath = explode('\\', get_class($storageLocation));

        return [
            'id' => (int) $storageLocation->getId(),
            'title' => $storageLocation->getTitle(),
            'status' => $storageLocation->getStatus(),
            'type' => end($classpath),
        ];
    }
}
