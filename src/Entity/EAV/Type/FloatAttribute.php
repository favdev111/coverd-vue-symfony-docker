<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FloatAttribute
 *
 * @ORM\Entity()
 */
class FloatAttribute extends Attribute
{
   /**
     * @var float
     *
     * @ORM\Column(name="float_value", type="float", nullable=true)
     */
    protected $value;

    public function getTypeLabel(): string
    {
        return "Decimal";
    }

    /**
     * @param float $value
     *
     * @return Attribute
     */
    public function setValue($value): Attribute
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    public function fixtureData()
    {
        return rand() / mt_getrandmax() * 10;
    }

    public function getDisplayInterfaces(): array
    {
        return [
            self::UI_NUMBER,
        ];
    }
}
