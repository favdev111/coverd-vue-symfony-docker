<?php

namespace App\DataFixtures;

use App\Entity\ZipCounty;
use Doctrine\Persistence\ObjectManager;

class ZipCountyFixtures extends BaseFixture
{
    public function loadData(ObjectManager $em)
    {
        $zipCounty = new ZipCounty();
        $zipCounty->setZipCode('66206');
        $zipCounty->setStateCode('KS');
        $zipCounty->setCountyName('Johnson County');
        $zipCounty->setCountyId('1234');
        $em->persist($zipCounty);

        $this->setReference('zip_county.1', $zipCounty);

        $em->flush();
    }
}
