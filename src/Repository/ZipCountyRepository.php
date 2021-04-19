<?php

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\ORM\EntityRepository;

class ZipCountyRepository extends EntityRepository
{
    public function findAllInConstraints(): array
    {
        $zipCountySetting = $this->getEntityManager()->getRepository(Setting::class)->find('zipCountyStates');
        $states = $zipCountySetting->getValue();

        if (empty($states)) {
            throw new \Exception('No states selected for Zip/County field in Admin');
        }

        $qb = $this->createQueryBuilder('z')
            ->where('z.stateCode in (:states)')
            ->setParameter('states', $states)
            ->orderBy('z.zipCode', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
