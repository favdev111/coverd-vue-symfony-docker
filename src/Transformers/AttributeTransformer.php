<?php

namespace App\Transformers;

use App\Entity\EAV\Attribute;
use App\Entity\EAV\Type\AddressAttribute;
use App\Entity\EAV\Type\ZipCountyAttribute;
use League\Fractal\TransformerAbstract;

class AttributeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'options'
    ];

    protected $defaultIncludes = [
        'value'
    ];

    public function transform(Attribute $attribute): array
    {
        return [
            'id' => (int) $attribute->getId(),
            'definition_id' => (int) $attribute->getDefinition()->getId(),
            'name' => $attribute->getDefinition()->getName(),
            'label' => $attribute->getDefinition()->getLabel(),
            'type' => $attribute->getDefinition()->getType(),
            'helpText' => $attribute->getDefinition()->getHelpText(),
            'displayInterface' => $attribute->getDefinition()->getDisplayInterface(),
            'orderIndex' => $attribute->getDefinition()->getOrderIndex(),
            'hasOptions' => $attribute->hasOptions(),
        ];
    }

    public function includeValue(Attribute $attribute)
    {
        if ($attribute->getValue() === null) {
            return $this->primitive(null);
        }

        if ($attribute instanceof AddressAttribute) {
            return $this->item($attribute->getValue(), new AddressTransformer());
        }

        if ($attribute instanceof ZipCountyAttribute) {
            return $this->item($attribute->getValue(), new ZipCountyTransformer());
        }

        return $this->primitive($attribute->getJsonValue());
    }

    public function includeOptions(Attribute $attribute)
    {
        $options = $attribute->getDefinition()->getOptions();

        return $this->collection($options, new AttributeDefinitionOptionTransformer());
    }
}
