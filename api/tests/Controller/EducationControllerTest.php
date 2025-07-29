<?php

namespace App\Tests\Controller;

use App\Repository\EducationRepository;
use App\Tests\Utils\BaseWebTestCase;
use App\Tests\Utils\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;

class EducationControllerTest extends BaseWebTestCase
{
    public function testCreateEducationReturnsCreatedEducationAndStatus201WhenAuthenticated(): void
    {
        $client = static::createClient();
        $repository = static::getContainer()->get(EducationRepository::class);

        $accessToken = $this->loginAndGetToken($client);

        $requestBody = TestDataProvider::educationRequestJson();

        $client->request(
            'POST',
            '/api/admin/education',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertSame($requestBody['institution_name'], $responseBody['institution_name']);
        $this->assertSame($requestBody['specialisation'], $responseBody['specialisation']);
        $this->assertStringContainsString($requestBody['start_date'], $responseBody['start_date']);
        $this->assertStringContainsString($requestBody['end_date'], $responseBody['end_date']);
        $this->assertSame($requestBody['display_order'], $responseBody['display_order']);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $education = $repository->find($responseBody['id']);

        $this->assertEquals($requestBody['institution_name'], $education->getInstitutionName());
        $this->assertEquals($requestBody['specialisation'], $education->getSpecialisation());
        $this->assertStringContainsString($requestBody['start_date'], $education->getStartDate()->format('Y-m-d'));
        $this->assertStringContainsString($requestBody['end_date'], $education->getEndDate()->format('Y-m-d'));
        $this->assertEquals($requestBody['display_order'], $education->getDisplayOrder());
    }

    public function testCreateEducationReturnsUnauthorizedWhenNotAuthenticated(): void
    {
        $client = static::createClient();
        $requestBody = TestDataProvider::educationRequestJson();

        $client->request(
            'POST',
            '/api/admin/education',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestBody)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetEducationReturnsEducationAndStatus200WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);

        $client->request(
            'GET',
            '/api/education/15',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('institution_name', $responseBody);
        $this->assertArrayHasKey('specialisation', $responseBody);
        $this->assertArrayHasKey('start_date', $responseBody);
        $this->assertArrayHasKey('end_date', $responseBody);
        $this->assertArrayHasKey('display_order', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteEducationReturnsStatus204WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);

        $client->request(
            'DELETE',
            '/api/admin/education/1',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testDeleteEducationReturnsUnauthorizedWhenNotAuthenticated(): void
    {
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/api/admin/education/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testUpdateEducationReturnsUpdatedEducationAndStatus200WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);


        $requestBody = [
            'institution_name' => 'New Institution Name',
            'specialisation' => 'New Specialisation',
        ];

        $client->request(
            'PATCH',
            '/api/admin/education/15',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($requestBody['institution_name'], $responseBody['institution_name']);
        $this->assertSame($requestBody['specialisation'], $responseBody['specialisation']);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
