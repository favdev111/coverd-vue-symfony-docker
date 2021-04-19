<?php

namespace App\Entity\EAV;

use App\Entity\Address;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class EavAddress extends Address
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
