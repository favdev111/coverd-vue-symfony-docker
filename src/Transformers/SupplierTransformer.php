<?php

namespace App\Transformers;

use App\Entity\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'addresses',
        'contacts',
    ];


    public function transform(Supplier $supplier)
    {
        return [
            'id' => (int) $supplier->getId(),
            'title' => $supplier->getTitle(),
            'status' => $supplier->getStatus(),
            'supplierType' => $supplier->getSupplierType(),
            'createdAt' => $supplier->getCreatedAt()->format('c'),
            'updatedAt' => $supplier->getUpdatedAt()->format('c'),
        ];
    }

    public function includeAddresses(Supplier $supplier)
    {
        $addresses = $supplier->getAddresses();

        return $this->collection($addresses, new SupplierAddressTransformer());
    }

    public function includeContacts(Supplier $supplier)
    {
        $contacts = $supplier->getContacts();

        return $this->collection($contacts, new SupplierContactTransformer());
    }
}
