<?php

namespace App\Tests\Entity;

use App\Entity\SupplierAddress;
use App\Tests\AbstractWebTestCase;

class SupplierAddressTest extends AbstractWebTestCase
{

    public function testIsValidReturnsTrueWhenNotEmpty()
    {
        $address = new SupplierAddress();
        $address->setStreet1('123 Main');
        $address->setCity('Anywhere');
        $address->setState('Texas');
        $address->setPostalCode('12345');
        $this->assertTrue($address->isValid());
    }


    /**
     * @testWith    [null, "Anywhere", "Texas", "12345"]
     *              ["123 Main", null, "Texas", "12345"]
     *              ["123 Main", "Anywhere", null, "12345"]
     *              ["123 Main", "Anywhere", "Texas", null]
     */
    public function testIsValidReturnsFalseWhenAnyEmpty(?string $addr1,
                                                        ?string $city,
                                                        ?string $stateAbr,
                                                        ?string $postCode)
    {
        $address = new SupplierAddress();
        $address->setStreet1($addr1);
        $address->setCity($city);
        $address->setState($stateAbr);
        $address->setPostalCode($postCode);
        $this->assertFalse($address->isValid());
    }
}
