<?php

namespace App\Transformers;

use App\Entity\SupplierAddress;
use League\Fractal\TransformerAbstract;

class SupplierAddressTransformer extends TransformerAbstract
{

    public function transform(SupplierAddress $address)
    {
        return [
            'id' => (int) $address->getId(),
            'title' => $address->getTitle(),
            'optionList' => sprintf("%s, %s", $address->getTitle(), $address->getStreet1()),
            'street1' => $address->getStreet1(),
            'street2' => $address->getStreet2(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'country' => $address->getCountry(),
            'postalCode' => $address->getPostalCode(),
            'isDeleted' => $address->isDeleted(),
        ];
    }
}
