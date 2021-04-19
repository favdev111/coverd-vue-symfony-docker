<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class DefinitionRepository extends EntityRepository
{
    public function findAllSorted()
    {
        return $this->findBy([], ['orderIndex' => 'ASC']);
    }
}
