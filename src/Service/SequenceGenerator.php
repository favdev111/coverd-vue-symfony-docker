<?php

namespace App\Service;

use App\Entity\Sequence;
use Doctrine\ORM\EntityManager;

class SequenceGenerator
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function generateNext($entity): int
    {
        $repo = $this->em->getRepository(Sequence::class);

        $sequence = $repo->findOneBy(["class" => get_class($entity)]);

        if (!$sequence) {
            $sequence = new Sequence(get_class($entity));
            $this->em->persist($sequence);
        }

        $nextSequence = $sequence->incrementSequence();

        $this->em->flush();

        return $nextSequence;
    }
}
