<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StringAttribute
 *
 * @ORM\Entity()
 */
class StringAttribute extends Attribute
{

    /**
     * @var string
     *
     * @ORM\Column(name="string_value", type="string", length=255, nullable=true)
     */
    protected $value;

    public function getTypeLabel(): string
    {
        return "Short Text";
    }

    /**
     * @param string $value
     *
     * @return Attribute
     */
    public function setValue($value): Attribute
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function fixtureData()
    {
        return "This is a test";
    }

    public function getDisplayInterfaces(): array
    {
        return [
            self::UI_TEXT
        ];
    }
}
