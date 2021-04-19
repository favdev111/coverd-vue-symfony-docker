<?php

namespace App\Entity\EAV;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ClientDefinition
 *
 * @ORM\Entity(repositoryClass="App\Repository\DefinitionRepository")
 */
class ClientDefinition extends Definition
{
    public $defaultEntityName = ClientDefinition::class;

    /**
     * @var boolean|null
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDuplicateReference;

    /**
     * @return bool
     */
    public function isDuplicateReference(): ?bool
    {
        return $this->isDuplicateReference;
    }

    /**
     * @param bool $isDuplicateReference
     */
    public function setIsDuplicateReference(?bool $isDuplicateReference): void
    {
        $this->isDuplicateReference = $isDuplicateReference;
    }
}
