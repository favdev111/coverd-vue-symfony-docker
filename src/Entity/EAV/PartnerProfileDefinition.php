<?php

namespace App\Entity\EAV;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PartnerProfileDefinition
 *
 * @ORM\Entity(repositoryClass="App\Repository\DefinitionRepository")
 */
class PartnerProfileDefinition extends Definition
{
    public $defaultEntityName = PartnerProfileDefinition::class;
}
