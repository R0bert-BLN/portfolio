<?php

namespace App\Tests\Controller;

use App\Tests\Utils\BaseWebTestCase;
use App\Tests\Utils\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;

class ContactHistoryControllerTest extends BaseWebTestCase
{
    public function testCreateContactHistoryReturnsCreatedContactHistoryAndStatus201WhenSuccess()
    {
        $client = static::createClient();
        $contactHistoryRequestDto = TestDataProvider::contactHistoryRequestJson();

        $client->request(
            'POST',
            '/api/contact-history',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($contactHistoryRequestDto)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('email', $responseBody);
        $this->assertArrayHasKey('message', $responseBody);
        $this->assertArrayHasKey('created_at', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testGetAllContactHistoryReturnsContactHistoryAndStatus200WhenSuccess()
    {
        $client = static::createClient();
        $token = $this->loginAndGetToken($client);

        $client->request(
            'GET',
            '/api/admin/contact-history',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetContactHistoryReturnsContactHistoryAndStatus200WhenSuccess()
    {
        $client = static::createClient();
        $token = $this->loginAndGetToken($client);
        $contactHistoryId = 1;

        $client->request(
            'GET',
            '/api/admin/contact-history/'.$contactHistoryId,
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('email', $responseBody);
        $this->assertArrayHasKey('message', $responseBody);
        $this->assertArrayHasKey('created_at', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteContactHistoryReturnsNoContentAndStatus204WhenSuccess(): void
    {
        $client = static::createClient();
        $token = $this->loginAndGetToken($client);
        $contactHistoryId = 2;

        $client->request(
            'DELETE',
            '/api/admin/contact-history/'.$contactHistoryId,
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '.$token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
