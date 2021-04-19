<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class StorageLocationAddress extends Address
{
    /**
     * @var StorageLocation
     *
     * @ORM\OneToOne(targetEntity="StorageLocation", inversedBy="address")
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
    public function setStorageLocation(StorageLocation $storageLocation)
    {
        $this->storageLocation = $storageLocation;
    }
}
