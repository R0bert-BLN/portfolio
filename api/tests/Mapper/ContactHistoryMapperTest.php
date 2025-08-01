<?php

namespace App\Tests\Mapper;

use App\Mapper\ContactHistoryMapper;
use App\Repository\ContactHistoryRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException as ReflectionExceptionAlias;

class ContactHistoryMapperTest extends BaseTestCase
{
    private MockObject $contactHistoryRepository;
    private ContactHistoryMapper $contactHistoryMapper;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contactHistoryRepository = $this->createMock(ContactHistoryRepository::class);
        $this->contactHistoryMapper = new ContactHistoryMapper($this->contactHistoryRepository);
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testDtoToEntityConversionWhenSuccess(): void
    {
        $contactHistoryDto = TestDataProvider::contactHistoryRequestDto();
        $contactHistoryEntity = TestDataProvider::contactHistoryEntity();

        $this->contactHistoryRepository
            ->expects($this->once())
            ->method('find')
            ->with($contactHistoryEntity->getId())
            ->willReturn($contactHistoryEntity);

        $result = $this->contactHistoryMapper->dtoToEntity($contactHistoryDto, $contactHistoryEntity->getId());

        $this->assertSame($contactHistoryEntity->getId(), $result->getId());
        $this->assertSame($contactHistoryDto->getName(), $result->getName());
        $this->assertSame($contactHistoryDto->getEmail(), $result->getEmail());
        $this->assertSame($contactHistoryDto->getMessage(), $result->getMessage());
        $this->assertNotNull($result->getCreatedAt());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testEntityToDtoConversionWhenSuccess(): void
    {
        $contactHistoryEntity = TestDataProvider::contactHistoryEntity();

        $result = $this->contactHistoryMapper->entityToDto($contactHistoryEntity);

        $this->assertSame($contactHistoryEntity->getId(), $result->getId());
        $this->assertSame($contactHistoryEntity->getName(), $result->getName());
        $this->assertSame($contactHistoryEntity->getEmail(), $result->getEmail());
        $this->assertSame($contactHistoryEntity->getMessage(), $result->getMessage());
        $this->assertSame(
            $contactHistoryEntity->getCreatedAt()->format('Y-m-d H:i:s'),
            $result->getCreatedAt()->format('Y-m-d H:i:s'));
    }
}
