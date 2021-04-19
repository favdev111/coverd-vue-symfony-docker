<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class StorageLocationContact extends Contact
{
    /**
     * @var StorageLocation
     *
     * @ORM\ManyToOne(targetEntity="StorageLocation", inversedBy="contacts" )
     */
    protected $storageLocation;

    /**
     * @return StorageLocation
     */
    public function getStorageLocation()
    {
        return $this->storageLocation;
    }

    /**
     * @param StorageLocation $storageLocation
     */
    public function setStorageLocation(StorageLocation $storageLocation = null)
    {
        $this->storageLocation = $storageLocation;
    }
}
