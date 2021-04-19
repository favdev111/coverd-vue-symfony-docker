<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TextAttribute
 *
 * @ORM\Entity()
 */
class TextAttribute extends Attribute
{

    /**
     * @var string
     *
     * @ORM\Column(name="text_value", type="text", nullable=true)
     */
    protected $value;

    public function getTypeLabel(): string
    {
        return "Long Text";
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
            self::UI_TEXTAREA,
        ];
    }
}
