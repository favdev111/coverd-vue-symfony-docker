<?php

namespace App\Tests\Controller;

use App\DataFixtures\ClientAttributeFixtures;
use App\DataFixtures\ClientFixtures;
use App\DataFixtures\GroupFixtures;
use App\DataFixtures\PartnerFixtures;
use App\DataFixtures\PartnerProfileAttributeFixtures;
use App\DataFixtures\PartnerProfileFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Client;
use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

/**
 * @group Integration
 * @coversNothing
 */
class ClientControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([
            PartnerFixtures::class,
            PartnerProfileAttributeFixtures::class,
            PartnerProfileFixtures::class,
            ClientAttributeFixtures::class,
            ClientFixtures::class,
            GroupFixtures::class,
            UserFixtures::class,
        ]);
    }

    public function testShow()
    {
        $this->loginAsAdmin();

        $clientAccount = $this->getClientAccount();
        $publicId = $clientAccount->getPublicId();
        $this->client->request('GET', "/api/clients/{$publicId}");

        /** @var array{id:string} $response */
        $response = $this->getDecodedResponse();

        $this->assertSame($publicId, $response['id']);
    }

    public function testCannotShowBadPublicId()
    {
        $this->loginAsAdmin();

        $badPublicId = '1234';

        $this->client->request('GET', "/api/clients/{$badPublicId}");

        $response = $this->getDecodedResponse();
        $this->assertResponseStatusCodeSame('404');
    }

    public function testUpdate()
    {
        $this->loginAsAdmin();

        $clientAccount = $this->getClientAccount();
        $publicId = $clientAccount->getPublicId();
        $name = $clientAccount->getName();
        $firstName = $name->getFirstName();
        $lastName = $name->getLastName();

        $newLastName = uniqid();

        $params = ['firstName' => $firstName, 'lastName' => $newLastName];

        $this->client->request('PATCH', "/api/clients/{$publicId}", $params);

        /** @var array{id:string, firstName:string, lastName:string} $response */
        $response = $this->getDecodedResponse();

        $this->assertSame($publicId, $response['id']);
        $this->assertSame($firstName, $response['firstName']);
        $this->assertSame($newLastName, $response['lastName']);
    }

    protected function getClientAccount(): Client
    {
        $clients = $this->objectManager->getRepository(Client::class)->findAll();

        return $clients[0];
    }
}
