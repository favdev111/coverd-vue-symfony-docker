<?php

namespace App\Entity\EAV;

use App\Entity\CoreEntity;
use App\Entity\EAV\Type\AddressAttribute;
use App\Entity\EAV\Type\BooleanAttribute;
use App\Entity\EAV\Type\DatetimeAttribute;
use App\Entity\EAV\Type\FloatAttribute;
use App\Entity\EAV\Type\IntegerAttribute;
use App\Entity\EAV\Type\OptionListAttribute;
use App\Entity\EAV\Type\StringAttribute;
use App\Entity\EAV\Type\TextAttribute;
use App\Entity\EAV\Type\ZipCountyAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Based on: https://github.com/Padam87/AttributeBundle
 *
 * @ORM\Entity(repositoryClass="App\Repository\DefinitionRepository")
 * @ORM\Table(name="attribute_definition", indexes={
 *      @ORM\Index(name="name_idx", columns={"name"})
 * })
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Definition extends CoreEntity
{
    public const TYPE_STRING = "STRING";
    public const TYPE_INTEGER = "INTEGER";
    public const TYPE_FLOAT = "FLOAT";
    public const TYPE_DATETIME = "DATETIME";
    public const TYPE_OPTION_LIST = "OPTION_LIST";
    public const TYPE_TEXT = "TEXT";
    public const TYPE_FILE = "FILE";
    public const TYPE_ADDRESS = "ADDRESS";
    public const TYPE_URL = "URL";
    public const TYPE_BOOLEAN = "BOOLEAN";
    public const TYPE_ZIPCODE = "ZIPCODE";

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Machine name for the field. Must be lowercase letters, numbers, or underscores.
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9_]+$/")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $helpText;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $displayInterface;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unit;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $required = false;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderIndex;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\EAV\Option",
     *     mappedBy="definition",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"},
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $options;

    /**
     * @var Attribute
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\EAV\Attribute",
     *     mappedBy="definition",
     *     cascade={"remove"}
     * )
     */
    private $attributes;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setType(string $type): Definition
    {
        $this->type = $type;

        // If not set, use the default interface of the attribute type.
        if (!$this->displayInterface) {
            $attribute = self::createNewAttributeFromType($type);
            $this->displayInterface = $attribute->getDefaultDisplayInterface();
        }

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * @return $this
     */
    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getDisplayInterface(): string
    {
        return $this->displayInterface;
    }

    public function setDisplayInterface(string $displayInterface): void
    {
        $this->displayInterface = $displayInterface;
    }

    /**
     * @param string $unit
     *
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param boolean $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param integer $orderIndex
     *
     * @return $this
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * @param Option $option
     *
     * @return $this
     */
    public function addOption(Option $option)
    {
        $this->options[] = $option;
        $option->setDefinition($this);

        return $this;
    }

    /**
     * @param Option $options
     */
    public function removeOption(Option $options)
    {
        $this->options->removeElement($options);
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param Attribute $attributes
     *
     * @return $this
     */
    public function addAttribute(Attribute $attributes)
    {
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * @param Attribute $attributes
     */
    public function removeAttribute(Attribute $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public static function getAttributeTypes(): array
    {
        return [
            self::TYPE_DATETIME,
            self::TYPE_FLOAT,
            self::TYPE_INTEGER,
            self::TYPE_STRING,
            self::TYPE_OPTION_LIST,
            self::TYPE_TEXT,
            self::TYPE_BOOLEAN,
            self::TYPE_ADDRESS,
            self::TYPE_URL,
            self::TYPE_ZIPCODE,
        ];
    }

    public static function createNewAttributeFromType(string $type): Attribute
    {
        $attribute = new StringAttribute();

        switch ($type) {
            case self::TYPE_STRING:
                $attribute = new StringAttribute();
                break;
            case self::TYPE_TEXT:
                $attribute = new TextAttribute();
                break;
            case self::TYPE_INTEGER:
                $attribute = new IntegerAttribute();
                break;
            case self::TYPE_FLOAT:
                $attribute = new FloatAttribute();
                break;
            case self::TYPE_DATETIME:
                $attribute = new DatetimeAttribute();
                break;
            case self::TYPE_OPTION_LIST:
                $attribute = new OptionListAttribute();
                break;
            case self::TYPE_BOOLEAN:
                $attribute = new BooleanAttribute();
                break;
            case self::TYPE_ADDRESS:
                $attribute = new AddressAttribute();
                break;
            case self::TYPE_ZIPCODE:
                $attribute = new ZipCountyAttribute();
                break;
        }

        return $attribute;
    }

    public function createAttribute($value = null): Attribute
    {
        $attribute = null;

        $attribute = self::createNewAttributeFromType($this->type);

        $attribute->setDefinition($this);
        $attribute->setValue($value);

        return $attribute;
    }

    public function getAttributeClass(): string
    {
        $attribute = self::createNewAttributeFromType($this->type);

        return get_class($attribute);
    }

    public function applyChangesFromArray(array $changes): void
    {
        if (isset($changes['options'])) {
            foreach ($changes['options'] as $changedOption) {
                if (isset($changedOption['id'])) {
                    $option = $this->getOption($changedOption['id']);
                } elseif (!isset($changedOption['isDeleted']) || !$changedOption['isDeleted']) {
                    $option = new Option();
                    $this->addOption($option);
                } else {
                    continue;
                }
                $option->applyChangesFromArray($changedOption);

                if (isset($changedOption['isDeleted']) && $changedOption['isDeleted']) {
                    $this->removeOption($option);
                }
            }
            unset($changes['options']);
        }

        parent::applyChangesFromArray($changes); // TODO: Change the autogenerated stub
    }

    public function getOption(int $id): Option
    {
        return $this->options->filter(function (Option $option) use ($id) {
            return $option->getId() == $id;
        })->first();
    }
}
