<?php

namespace App\Transformers;

use App\Entity\EAV\Option;
use League\Fractal\TransformerAbstract;

class AttributeDefinitionOptionTransformer extends TransformerAbstract
{
    public function transform(Option $option)
    {
        return [
            'id' => (int) $option->getId(),
            'name' => $option->getName(),
            'value' => $option->getValue(),
        ];
    }
}
