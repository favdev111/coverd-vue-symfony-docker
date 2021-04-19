<?php

namespace App\DataFixtures;

use App\Entity\StorageLocationAddress;
use App\Entity\StorageLocationContact;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Warehouse;

class WarehouseFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $main = new Warehouse('Main Warehouse');
        $main->setAddress($this->createAddress(StorageLocationAddress::class));
        $main->addContact($this->createContact(StorageLocationContact::class));
        $manager->persist($main);
        $this->setReference('warehouse_main', $main);

        $backup = new Warehouse('Backup Warehouse');
        $backup->setAddress($this->createAddress(StorageLocationAddress::class));
        $backup->addContact($this->createContact(StorageLocationContact::class));
        $manager->persist($backup);
        $this->setReference('warehouse_backup', $backup);

        $manager->flush();
    }
}
