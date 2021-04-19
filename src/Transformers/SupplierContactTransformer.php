<?php

namespace App\Transformers;

use App\Entity\SupplierContact;
use League\Fractal\TransformerAbstract;

class SupplierContactTransformer extends TransformerAbstract
{

    public function transform(SupplierContact $contact)
    {
        return [
            'id' => (int) $contact->getId(),
            'firstName' => $contact->getName()->getFirstname(),
            'lastName' => $contact->getName()->getLastname(),
            'phoneNumber' => $contact->getPhoneNumber(),
            'email' => $contact->getEmail(),
            'title' => $contact->getTitle(),
            'isDeleted' => $contact->isDeleted(),
        ];
    }
}
