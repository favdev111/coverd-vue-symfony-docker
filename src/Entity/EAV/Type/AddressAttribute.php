<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use App\Entity\EAV\EavAddress;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AddressAttribute
 *
 * @ORM\Entity()
 */
class AddressAttribute extends Attribute
{

    /**
     * @var EavAddress
     *
     * @ORM\OneToOne(targetEntity="App\Entity\EAV\EavAddress", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="address_id")
     */
    private $value;

    public function getTypeLabel(): string
    {
        return "Address";
    }

    /**
     * @param EavAddress|array $value
     *
     * @return Attribute
     */
    public function setValue($value): Attribute
    {
        if (is_array($value)) {
            if (isset($value['id'])) {
                $address = $this->getValue();
            } else {
                $address = new EavAddress();
            }
            $address->applyChangesFromArray($value);
        } else {
            $address = $value;
        }

        if (!$address instanceof EavAddress && !is_null($address)) {
            throw new \TypeError("Value is not an Address. It's an %s", get_class($address));
        }

        $this->value = $address;

        return $this;
    }

    /**
     * @return EavAddress
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getValueType(): string
    {
        return EavAddress::class;
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
            self::UI_ADDRESS,
        ];
    }
}
