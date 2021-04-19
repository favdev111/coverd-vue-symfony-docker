<?php

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class ApiSerializer
 *
 * This class overrides the ArraySerializer so that the 'data' property does not show up on all 1:n relationship
 * properties
 *
 * @package App\Serializer
 */
class ApiSerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }
}
