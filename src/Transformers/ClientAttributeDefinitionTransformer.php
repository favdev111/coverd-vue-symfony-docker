<?php

namespace App\Transformers;

use App\Entity\EAV\ClientDefinition;
use App\Entity\EAV\Definition;

class ClientAttributeDefinitionTransformer extends AttributeDefinitionTransformer
{
    /**
     * @param ClientDefinition $attribute
     * @return array
     */
    public function transform(Definition $attribute)
    {
        $fields = parent::transform($attribute);
        $fields['isDuplicateReference'] = $attribute->isDuplicateReference();

        return $fields;
    }
}
