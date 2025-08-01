<?php

namespace App\Tests\Controller;

use App\Tests\Utils\BaseWebTestCase;
use App\Tests\Utils\TestDataProvider;
use Symfony\Component\HttpFoundation\Response;

class WorkExperienceControllerTest extends BaseWebTestCase
{
    public function testCreateWorkExperienceReturnsWorkExperienceAndStatus201WhenSuccessful(): void
    {
        $client = self::createClient();
        $token = $this->loginAndGetToken($client);
        $requestBody = TestDataProvider::workExperienceRequestJson();

        $client->request(
            'POST',
            '/api/admin/work-experience',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer '.$token],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertSame($requestBody['company'], $responseBody['company']);
        $this->assertSame($requestBody['job_title'], $responseBody['job_title']);
        $this->assertSame($requestBody['job_description'], $responseBody['job_description']);
        $this->assertStringContainsString($requestBody['start_date'], $responseBody['start_date']);
        $this->assertStringContainsString($requestBody['end_date'], $responseBody['end_date']);
        $this->assertSame($requestBody['display_order'], $responseBody['display_order']);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function testGetAllWorkExperiencesReturnsWorkExperiencesAndStatus200WhenSuccessful(): void
    {
        $client = self::createClient();

        $client->request('GET', '/api/work-experience');

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetWorkExperienceReturnsWorkExperienceAndStatus200WhenSuccessful(): void
    {
        $client = self::createClient();
        $id = 1;

        $client->request('GET', '/api/work-experience/'.$id);

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $responseBody);
        $this->assertArrayHasKey('company', $responseBody);
        $this->assertArrayHasKey('job_title', $responseBody);
        $this->assertArrayHasKey('job_description', $responseBody);
        $this->assertArrayHasKey('start_date', $responseBody);
        $this->assertArrayHasKey('end_date', $responseBody);
        $this->assertArrayHasKey('display_order', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testUpdateWorkExperienceReturnsWorkExperienceAndStatus200WhenSuccessful(): void
    {
        $client = self::createClient();
        $token = $this->loginAndGetToken($client);
        $id = 1;
        $requestBody = [
            'company' => 'New Company',
            'job_title' => 'New Job',
        ];

        $client->request(
            'PATCH',
            '/api/admin/work-experience/'.$id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer '.$token],
            json_encode($requestBody)
        );

        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($requestBody['company'], $responseBody['company']);
        $this->assertSame($requestBody['job_title'], $responseBody['job_title']);
        $this->assertArrayHasKey('job_description', $responseBody);
        $this->assertArrayHasKey('start_date', $responseBody);
        $this->assertArrayHasKey('end_date', $responseBody);
        $this->assertArrayHasKey('display_order', $responseBody);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteWorkExperienceReturnsStatus204WhenSuccessful(): void
    {
        $client = self::createClient();
        $token = $this->loginAndGetToken($client);
        $id = 2;

        $client->request('DELETE', '/api/admin/work-experience/'.$id, [], [], ['HTTP_Authorization' => 'Bearer '.$token]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
