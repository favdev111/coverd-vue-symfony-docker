<?php

namespace App\Entity;

use App\Entity\Orders\SupplyOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Supplier class for suppliers of products
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\SupplierRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable()
 */

class Supplier extends CoreEntity
{
    public const STATUS_ACTIVE = "ACTIVE";
    public const STATUS_INACTIVE = "INACTIVE";

    public const TYPE_DONOR = "DONOR";
    public const TYPE_VENDOR = "VENDOR";
    public const TYPE_DIAPERDRIVE = "DIAPERDRIVE";
    public const TYPE_DROPSITE = "DROPSITE";

    public const ROLE_VIEW = "ROLE_SUPPLIER_VIEW";
    public const ROLE_EDIT = "ROLE_SUPPLIER_EDIT";

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @var ArrayCollection|SupplierAddress[]
     *
     * @ORM\OneToMany(
     *     targetEntity="SupplierAddress",
     *     mappedBy="supplier",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     *
     * @Assert\Type(type="array")
     */
    protected $addresses;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Gedmo\Versioned
     */
    protected $status;

    /**
     * @var ArrayCollection|SupplierContact[]
     *
     * @ORM\OneToMany(
     *     targetEntity="SupplierContact",
     *     mappedBy="supplier",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     *
     * @Assert\Type(type="array")
     */
    protected $contacts;

    /**
     * @var ArrayCollection|SupplyOrder[] $supplyOrders
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Orders\SupplyOrder",
     *     mappedBy="supplier",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    protected $supplyOrders;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\Versioned
     */
    protected $supplierType;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;

    /**
     * Supplier constructor.
     * @param string $title
     */
    public function __construct($title = null)
    {
        $this->setTitle($title);
        $this->status = self::STATUS_ACTIVE;
        $this->addresses = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->supplyOrders = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return SupplierAddress[]|ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     *
     * @param int $id
     * @return SupplierAddress
     */
    public function getAddress($id)
    {
        return $this->addresses->filter(function (SupplierAddress $address) use ($id) {
            return $address->getId() == $id;
        })->first();
    }

    /**
     * @param SupplierAddress $address
     */
    public function addAddress(SupplierAddress $address)
    {
        if (!isset($this->addresses)) {
            $this->addresses = new ArrayCollection();
        }
        $this->addresses->add($address);
        $address->setSupplier($this);
    }

    public function removeAddress(SupplierAddress $address)
    {
        /** @var SupplierContact $found */
        $found = $this->addresses->filter(function (SupplierAddress $a) use ($address) {
            return $a->getId() === $address->getId();
        })->first();

        $found->setSupplier(null);
        $this->addresses->removeElement($found);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return SupplierContact[]|ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param SupplierContact[]|ArrayCollection $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     *
     * @param int $id
     * @return SupplierContact
     */
    public function getContact($id)
    {
        return $this->contacts->filter(function (SupplierContact $contact) use ($id) {
            return $contact->getId() == $id;
        })->first();
    }

    public function addContact(SupplierContact $contact)
    {
        if (!isset($this->contacts)) {
            $this->contacts = new ArrayCollection();
        }
        $this->contacts->add($contact);
        $contact->setSupplier($this);
    }

    public function removeContact(SupplierContact $contact)
    {
        /** @var SupplierContact $found */
        $found = $this->contacts->filter(function (SupplierContact $c) use ($contact) {
            return $c->getId() === $contact->getId();
        })->first();

        $found->setSupplier(null);
        $this->contacts->removeElement($found);
    }

    /**
     * @return string
     */
    public function getSupplierType()
    {
        return $this->supplierType;
    }

    /**
     * @param string $supplierType
     */
    public function setSupplierType($supplierType)
    {
        $this->supplierType = $supplierType;
    }

    /**
     * @return SupplyOrder[]|ArrayCollection
     */
    public function getSupplyOrders()
    {
        return $this->supplyOrders;
    }

    /**
     * @return integer
     */
    public function getLegacyId(): int
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;
    }

    /**
     * {@inheritDoc}
     */
    public function applyChangesFromArray(array $changes): void
    {
        if (isset($changes['addresses'])) {
            foreach ($changes['addresses'] as $changedAddress) {
                if (isset($changedAddress['id'])) {
                    $address = $this->getAddress($changedAddress['id']);
                } elseif (!isset($changedAddress['isDeleted']) || !$changedAddress['isDeleted']) {
                    $address = new SupplierAddress();
                    $this->addAddress($address);
                } else {
                    continue;
                }
                $address->applyChangesFromArray($changedAddress);

                if ((isset($changedAddress['isDeleted']) && $changedAddress['isDeleted']) || !$address->isValid()) {
                    $this->removeAddress($address);
                }
            }
            unset($changes['addresses']);
        }

        if (isset($changes['contacts'])) {
            foreach ($changes['contacts'] as $changedContact) {
                if (isset($changedContact['id'])) {
                    $contact = $this->getContact($changedContact['id']);
                } elseif (!isset($changedContact['isDeleted']) || !$changedContact['isDeleted']) {
                    $contact = new SupplierContact();
                    $this->addContact($contact);
                } else {
                    continue;
                }
                $contact->applyChangesFromArray($changedContact);

                if ((isset($changedContact['isDeleted']) && $changedContact['isDeleted']) || !$contact->isValid()) {
                    $this->removeContact($contact);
                }
            }
            unset($changes['contacts']);
        }

        parent::applyChangesFromArray($changes);
    }
}
