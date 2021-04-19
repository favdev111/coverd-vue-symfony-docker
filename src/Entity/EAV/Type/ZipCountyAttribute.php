<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use App\Entity\EAV\EavAddress;
use App\Entity\ZipCounty;
use Doctrine\ORM\Mapping as ORM;
use http\Exception\UnexpectedValueException;

/**
 * Class ZipCOuntyAttribute
 *
 * @ORM\Entity()
 */
class ZipCountyAttribute extends Attribute
{

    /**
     * @var ZipCounty
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ZipCounty")
     * @ORM\JoinColumn(name="zip_county_id")
     */
    private $value;

    public function getTypeLabel(): string
    {
        return "Zip/County";
    }

    /**
     * @param ZipCounty $value
     *
     * @return Attribute
     */
    public function setValue($value): Attribute
    {
        if (!$value instanceof ZipCounty && !is_null($value)) {
            throw new \TypeError("Value is not an Zip/County. Got %s", get_class($value));
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return ZipCounty
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getValueType(): string
    {
        return ZipCounty::class;
    }

    public function isEmpty(): bool
    {
        return !$this->getValue();
    }

    public function fixtureData()
    {
        $address = new EavAddress();
        $address->setStreet1("123 Main St");
        $address->setCity("Kansas City");
        $address->setState("MO");
        $address->setCountry("USA");
        $address->setPostalCode("64110");

        return $address;
    }

    public function getDisplayInterfaces(): array
    {
        return [
            self::UI_ZIPCODE,
        ];
    }
}
