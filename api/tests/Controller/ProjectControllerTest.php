<?php

namespace App\Tests\Controller;

use App\Tests\Utils\BaseWebTestCase;
use App\Tests\Utils\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends BaseWebTestCase
{
    public function testCreateProjectReturnsCreatedProjectAndStatus201WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);
        $requestBody = TestDataProvider::projectRequestJson();
        $requestBody['skills'] = [2];

        $client->request('POST', '/api/admin/project', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
        ], json_encode($requestBody));

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('description', $responseBody);
        $this->assertArrayHasKey('picture_url', $responseBody);
        $this->assertArrayHasKey('github_link', $responseBody);
        $this->assertArrayHasKey('skills', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testGetProjectsReturnsProjectsAndStatus200WhenSuccessful(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/project');

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetProjectReturnsProjectAndStatus200WhenSuccessful(): void
    {
        $client = static::createClient();
        $projectId = 2;

        $client->request('GET', '/api/project/' . $projectId);

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('name', $responseBody);
        $this->assertArrayHasKey('description', $responseBody);
        $this->assertArrayHasKey('picture_url', $responseBody);
        $this->assertArrayHasKey('github_link', $responseBody);
        $this->assertArrayHasKey('skills', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testUpdateProjectReturnsUpdatedProjectAndStatus200WhenAuthenticated(): void
    {
        $client = static::createClient();
        $requestBody = TestDataProvider::projectRequestJson();
        $requestBody['skills'] = [2, 3];
        $accessToken = $this->loginAndGetToken($client);
        $projectId = 2;

        $client->request('PATCH', '/api/admin/project/'.$projectId, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
        ], json_encode($requestBody));

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($projectId, $responseBody['id']);
        $this->assertSame($requestBody['name'], $responseBody['name']);
        $this->assertSame($requestBody['description'], $responseBody['description']);
        $this->assertSame($requestBody['picture_url'], $responseBody['picture_url']);
        $this->assertSame($requestBody['github_link'], $responseBody['github_link']);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteProjectReturnsNoContentAndStatus204WhenAuthenticated(): void
    {
        $client = static::createClient();
        $accessToken = $this->loginAndGetToken($client);
        $projectId = 1;

        $client->request('DELETE', '/api/admin/project/'.$projectId, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer '.$accessToken,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
