<?php

namespace App\Transformers;

use App\Entity\PartnerContact;
use App\Entity\StorageLocationContact;

class PartnerContactTransformer extends StorageLocationContactTransformer
{
    /**
     * @param PartnerContact $contact
     * @return array
     */
    public function transform(StorageLocationContact $contact): array
    {
        $fields = parent::transform($contact);

        $fields['isProgramContact'] = $contact->isProgramContact();

        return $fields;
    }
}
