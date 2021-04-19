<?php

namespace App\Entity\EAV;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\EntityListeners({"App\Listener\AttributeListener"})
 *
 * Based on: https://github.com/Padam87/AttributeBundle
 */
abstract class Attribute
{
    public const UI_TEXT = "TEXT";
    public const UI_NUMBER = "NUMBER";
    public const UI_TEXTAREA = "TEXTAREA";
    public const UI_DATETIME = "DATETIME";
    public const UI_SELECT_SINGLE = "SELECT_SINGLE";
    public const UI_SELECT_MULTI = "SELECT_MULTI";
    public const UI_FILE_UPLOAD = "FILE_UPLOAD";
    public const UI_RADIO = "RADIO";
    public const UI_CHECKBOX_GROUP = "CHECKBOX_GROUP";
    public const UI_TOGGLE = "TOGGLE";
    public const UI_YES_NO_RADIO = "YES_NO_RADIO";
    public const UI_ADDRESS = "ADDRESS";
    public const UI_URL = "URL";
    public const UI_ZIPCODE = "ZIPCODE";

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Definition
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\EAV\Definition", inversedBy="attributes")
     * @ORM\JoinColumn(name="definition_id", referencedColumnName="id", nullable=false)
     */
    private $definition;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDefinition()->getLabel();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a human readable name for this attribute type.
     */
    abstract public function getTypeLabel(): string;

    abstract public function setValue($value): Attribute;

    abstract public function getValue();

    public function getValueType(): string
    {
        return 'string';
    }

    abstract public function getDisplayInterfaces(): array;

    /**
     * By default this will just get the first interface in the list. Override as necessary.
     */
    public function getDefaultDisplayInterface(): string
    {
        $interfaces = $this->getDisplayInterfaces();
        return reset($interfaces);
    }

    /**
     * Whether this type supports list options (dropdown, radio, checkboxes, etc)
     */
    public function hasOptions(): bool
    {
        return false;
    }

    public function isEmpty(): bool
    {
        return $this->getValue() === '' || is_null($this->getValue());
    }

    /**
     * Returns a value suitable for json responses.
     * @return mixed
     */
    public function getJsonValue()
    {
        return $this->getValue() ?: '';
    }

    /**
     * @param Definition $definition
     *
     * @return Attribute
     */
    public function setDefinition(Definition $definition = null)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * @return Definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    abstract public function fixtureData();
}
