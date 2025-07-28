<?php

namespace App\Tests\Utils;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    protected function setProperty(object $object, string $property, mixed $value): void
    {
        $reflectionProperty = new \ReflectionProperty($object, $property);
        $reflectionProperty->setValue($object, $value);
    }
}
