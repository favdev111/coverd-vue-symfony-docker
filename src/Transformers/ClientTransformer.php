<?php

namespace App\Transformers;

use App\Entity\Client;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'partner',
        'attributes',
        'lastDistribution',
    ];

    public function transform(Client $client): array
    {
        return [
            'id' => $client->getPublicId(),
            'firstName' => $client->getName()->getFirstname(),
            'lastName' => $client->getName()->getLastname(),
            'fullName' => $client->getName()->getFirstName() . ' ' . $client->getName()->getLastName(),
            'parentFirstName' => $client->getParentFirstName(),
            'parentLastName' => $client->getParentLastName(),
            'parentFullName' => $client->getParentFirstName() . ' ' . $client->getParentLastName(),
            'selectListText' => sprintf(
                '%s %s (%s)',
                $client->getName()->getFirstname(),
                $client->getName()->getLastname(),
                $client->getPublicId()
            ),
            'birthdate' => $client->getBirthdate()->format('c'),
            'isExpirationOverridden' => $client->isExpirationOverridden(),
            'ageExpiresAt' => $client->getAgeExpiresAt()->format('c'),
            'distributionExpiresAt' => $client->getDistributionExpiresAt() ?
                $client->getDistributionExpiresAt()->format('c') : null,
            'pullupDistributionMax' => $client->getPullupDistributionMax(),
            'pullupDistributionCount' => $client->getPullupDistributionCount(),
            'updatedAt' => $client->getUpdatedAt()->format('c'),
            'createdAt' => $client->getCreatedAt()->format('c'),
            'status' => $client->getStatus(),
            'canReview' => $client->canReview(),
            'canPartnerTransfer' => $client->canPartnerTransfer(),
            'isActive' => $client->isActive(),
        ];
    }

    public function includeAttributes(Client $client)
    {
        return $this->collection($client->getAttributes()->toArray(), new AttributeTransformer());
    }

    public function includePartner(Client $client)
    {
        return $client->getPartner()
            ? $this->item($client->getPartner(), new PartnerTransformer())
            : $this->primitive(['id' => null]);
    }

    public function includeLastDistribution(Client $client): ?Item
    {
        if ($client->getLastCompleteDistributionLineItem()) {
            return $this->item(
                $client->getLastCompleteDistributionLineItem(),
                new BulkDistributionLineItemTransformer()
            );
        }

        return null;
    }
}
