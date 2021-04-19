<?php

namespace App\Controller;

use App\Entity\EAV\ClientDefinition;
use App\Transformers\ClientAttributeDefinitionTransformer;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseAttributeController
 * @package App\Controller
 *
 * @Route(path="/api/client/attribute/definition")
 */
class ClientAttributeDefinitionController extends BaseAttributeDefinitionController
{
    protected $defaultEntityName = ClientDefinition::class;

    protected function getNewDefinition()
    {
        return new ClientDefinition();
    }

    protected function getDefaultTransformer(): ClientAttributeDefinitionTransformer
    {
        return new ClientAttributeDefinitionTransformer();
    }
}
