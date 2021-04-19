<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderSequence
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class Sequence
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $class;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $sequence;

    public function __construct($class)
    {
        $this->class = $class;
        $this->sequence = 0;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return int
     */
    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function incrementSequence(): int
    {
        $this->sequence++;
        return $this->sequence;
    }
}
