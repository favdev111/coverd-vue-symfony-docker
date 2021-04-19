<?php

namespace App\Entity\EAV\Type;

use App\Entity\EAV\Attribute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DateTimeAttribute
 *
 * @ORM\Entity()
 */
class DatetimeAttribute extends Attribute
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_value", type="datetime_immutable", nullable=true)
     */
    protected $value;

    public function getTypeLabel(): string
    {
        return "Date and Time";
    }

    /**
     * @param \DateTimeImmutable|string $value
     *
     * @return Attribute
     */
    public function setValue($value): Attribute
    {
        if (is_string($value) && $value !== '') {
            $value = \DateTimeImmutable::createFromFormat(\DateTime::RFC3339, $value);
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getValueType(): string
    {
        return \DateTime::class;
    }

    public function getJsonValue()
    {
        return $this->value ? $this->value->format('c') : '';
    }

    public function fixtureData()
    {
        return new \DateTimeImmutable();
    }

    public function getDisplayInterfaces(): array
    {
        return [
            self::UI_DATETIME,
        ];
    }
}
