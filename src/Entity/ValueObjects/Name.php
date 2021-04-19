<?php

namespace App\Entity\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Name
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $lastname;

    /**
     * @param string $firstname
     * @param string $lastname
     */
    public function __construct($firstname = null, $lastname = null)
    {
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
    }

    public function __toString()
    {
        return sprintf('%s %s', $this->getFirstname(), $this->getLastname());
    }

    public static function fromString($fullName)
    {
        $parts = explode(' ', $fullName);
        $first = implode(' ', array_slice($parts, 0, -1));
        $last = implode('', array_slice($parts, -1, 1));
        return new self($first, $last);
    }

    public function toArray()
    {
        return [
            "firstName" => $this->getFirstname(),
            "lastName" => $this->getLastname(),
        ];
    }

    public function isValid()
    {
        return !empty($this->firstname) || !empty($this->lastname);
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
}
