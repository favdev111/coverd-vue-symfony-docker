<?php

namespace App\Controller;

use App\Entity\EAV\PartnerProfileDefinition;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseAttributeController
 * @package App\Controller
 *
 * @Route(path="/api/partner/attribute/definition")
 */
class PartnerProfileAttributeDefinitionController extends BaseAttributeDefinitionController
{
    protected $defaultEntityName = PartnerProfileDefinition::class;

    protected function getNewDefinition()
    {
        return new PartnerProfileDefinition();
    }
}
