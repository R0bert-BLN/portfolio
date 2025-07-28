<?php

namespace App\Tests\Controller;

use App\Repository\ProfileRepository;
use App\Tests\Utils\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProfileControllerTest extends BaseWebTestCase
{
    public function testEditProfileReturnsUpdatedProfileAndStatus200WhenAuthenticated(): void
    {
        $client = static::createClient();
        $repository = static::getContainer()->get(ProfileRepository::class);

        $accessToken = $this->loginAndGetToken($client);
        $profileId = 2;

        $requestBody = [
            'first_name' => 'Rob',
            'last_name' => 'Stark',
        ];

        $client->request(
            'PATCH',
            '/api/admin/profile',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($profileId, $responseBody['id']);
        $this->assertSame('Rob', $responseBody['first_name']);
        $this->assertSame('Stark', $responseBody['last_name']);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $updatedProfile = $repository->find($profileId);

        $this->assertSame('Rob', $updatedProfile->getFirstName());
        $this->assertSame('Stark', $updatedProfile->getLastName());
    }

    public function testEditProfileReturnsStatus401WhenNotAuthenticated(): void
    {
        $client = static::createClient();

        $requestBody = [
            'first_name' => 'Rob',
            'last_name' => 'Stark',
        ];

        $client->request(
            'PATCH',
            '/api/admin/profile',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testEditProfileReturnsStatus400WhenInvalidJson(): void
    {
        $client = static::createClient();
        $repository = static::getContainer()->get(ProfileRepository::class);

        $accessToken = $this->loginAndGetToken($client);
        $profileId = 2;

        $requestBody = [
            'first_na' => 'Rob',
            'last_name' => 'Stark',
        ];

        $client->request(
            'PATCH',
            '/api/admin/profile',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('InvalidJsonException', $responseBody['title']);
        $this->assertSame(400, $responseBody['status_code']);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testGetProfileReturnsProfileAndStatus200(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/profile',
            [],
            [],
            [],
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('first_name', $responseBody);
        $this->assertArrayHasKey('last_name', $responseBody);
        $this->assertArrayHasKey('job_title', $responseBody);
        $this->assertArrayHasKey('description', $responseBody);
        $this->assertArrayHasKey('cv_url', $responseBody);
        $this->assertArrayHasKey('github_link', $responseBody);
        $this->assertArrayHasKey('linkedin_link', $responseBody);
        $this->assertArrayHasKey('picture_url', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
