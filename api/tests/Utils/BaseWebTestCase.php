<?php

namespace App\Tests\Utils;

use ReflectionException as ReflectionExceptionAlias;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTestCase extends WebTestCase
{
    private const EMAIL = 'your_email@test.com';
    private const PASSWORD = 'your_test_password';

    /**
     * @throws ReflectionExceptionAlias
     */
    protected function setProperty(object $object, string $property, mixed $value): void
    {
        $reflectionProperty = new \ReflectionProperty($object, $property);
        $reflectionProperty->setValue($object, $value);
    }

    protected function loginAndGetToken($client): string
    {
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => self::EMAIL,
                'password' => self::PASSWORD,
            ])
        );

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);

        return $data['token'];
    }
}
