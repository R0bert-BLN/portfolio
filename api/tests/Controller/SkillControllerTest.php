<?php

namespace App\Tests\Controller;

use App\Repository\SkillRepository;
use App\Tests\Utils\BaseWebTestCase;
use App\Tests\Utils\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;

class SkillControllerTest extends BaseWebTestCase
{
    public function testCreateSkillReturnsCreatedSkillAndStatus201WhenAuthenticated(): void
    {
        $client = static::createClient();
        $repository = static::getContainer()->get(SkillRepository::class);
        $accessToken = $this->loginAndGetToken($client);

        $client->request(
            'POST',
            '/api/admin/skill',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode(TestDataProvider::skillRequestJson())
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('type', $responseBody);
        $this->assertArrayHasKey('display_order', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $createdSkill = $repository->find($responseBody['id']);

        $this->assertSame($responseBody['name'], $createdSkill->getName());
        $this->assertSame($responseBody['type'], $createdSkill->getType());
        $this->assertSame($responseBody['display_order'], $createdSkill->getDisplayOrder());
    }

    public function testGetSkillReturnsSkillAndStatus200WhenSuccessful(): void
    {
        $client = static::createClient();
        $skillId = 2;

        $client->request(
            'GET',
            '/api/skill/'.$skillId,
            [],
            [],
            [],
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('type', $responseBody);
        $this->assertArrayHasKey('display_order', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetAllSkillsReturnsSkillsAndStatus200WhenSuccessful(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/skill',
            [],
            [],
            [],
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testUpdateSkillReturnsUpdatedSkillAndStatus200WhenAuthenticated(): void
    {
        $client = static::createClient();
        $requestBody = TestDataProvider::skillRequestJson();
        $accessToken = $this->loginAndGetToken($client);
        $skillId = 2;

        $client->request(
            'PATCH',
            '/api/admin/skill/'.$skillId,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($skillId, $responseBody['id']);
        $this->assertSame($requestBody['name'], $responseBody['name']);
        $this->assertSame($requestBody['type'], $responseBody['type']);
        $this->assertSame($requestBody['display_order'], $responseBody['display_order']);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testUpdateSkillReturnsUnauthorizedWhenNotAuthenticated(): void
    {
        $client = static::createClient();
        $requestBody = TestDataProvider::skillRequestJson();

        $client->request(
            'PATCH',
            '/api/admin/skill/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestBody)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testDeleteSkillReturnsUnauthorizedWhenNotAuthenticated(): void
    {
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/api/admin/skill/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testDeleteSkillReturnsStatus204WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);

        $client->request(
            'DELETE',
            '/api/admin/skill/1',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
