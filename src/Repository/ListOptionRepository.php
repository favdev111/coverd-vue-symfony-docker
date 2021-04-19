<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ListOptionRepository extends EntityRepository
{
    public function findOneByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }
}
