<?php

namespace App\Transformers;

use App\Entity\StorageLocationContact;
use League\Fractal\TransformerAbstract;

class StorageLocationContactTransformer extends TransformerAbstract
{

    public function transform(StorageLocationContact $contact)
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
