<?php

namespace App\Transformers;

use App\Entity\EAV\Definition;
use League\Fractal\TransformerAbstract;

class AttributeDefinitionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'options'
    ];

    public function transform(Definition $definition)
    {
        return [
            'id' => (int) $definition->getId(),
            'name' => $definition->getName(),
            'label' => $definition->getLabel(),
            'type' => $definition->getType(),
            'helpText' => $definition->getHelpText(),
            'displayInterface' => $definition->getDisplayInterface(),
            'description' => $definition->getDescription(),
            'required' => $definition->getRequired(),
            'options' => $definition->getOptions()->getValues(),
            'orderIndex' => $definition->getOrderIndex(),
        ];
    }

    public function includeOptions(Definition $definition)
    {
        $options = $definition->getOptions();

        return $this->collection($options, new AttributeDefinitionOptionTransformer());
    }
}
