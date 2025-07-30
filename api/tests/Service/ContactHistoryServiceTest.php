<?php

namespace App\Tests\Service;

use App\Entity\ContactHistory;
use App\Mapper\ContactHistoryMapper;
use App\Repository\ContactHistoryRepository;
use App\Service\ContactHistoryService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class ContactHistoryServiceTest extends BaseTestCase
{
    private MockObject $contactHistoryRepositoryMock;
    private MockObject $entityManagerMock;
    private ContactHistoryService $contactHistoryService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contactHistoryRepositoryMock = $this->createMock(ContactHistoryRepository::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->contactHistoryService = new ContactHistoryService(
            $this->contactHistoryRepositoryMock,
            $this->entityManagerMock,
            new ContactHistoryMapper($this->contactHistoryRepositoryMock));
    }

    public function testCreateContactHistoryWhenSuccess(): void
    {
        $contactHistoryDto = TestDataProvider::contactHistoryRequestDto();

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->willReturnCallback(function (ContactHistory $contactHistory) {
                $this->setProperty($contactHistory, 'id', 1);
                $this->setProperty($contactHistory, 'createdAt', new \DateTime('2023-01-01'));
            });

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->contactHistoryService->createContactHistory($contactHistoryDto);

        $this->assertNotNull($result->getId());
        $this->assertSame($contactHistoryDto->getName(), $result->getName());
        $this->assertSame($contactHistoryDto->getEmail(), $result->getEmail());
        $this->assertSame($contactHistoryDto->getMessage(), $result->getMessage());
        $this->assertNotNull($result->getCreatedAt());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetContactHistoryWhenSuccess(): void
    {
        $contactHistoryEntity = TestDataProvider::contactHistoryEntity();

        $this->contactHistoryRepositoryMock->expects($this->once())
            ->method('find')
            ->with($contactHistoryEntity->getId())
            ->willReturn($contactHistoryEntity);

        $result = $this->contactHistoryService->getContactHistory($contactHistoryEntity->getId());

        $this->assertSame($contactHistoryEntity->getId(), $result->getId());
        $this->assertSame($contactHistoryEntity->getName(), $result->getName());
        $this->assertSame($contactHistoryEntity->getEmail(), $result->getEmail());
        $this->assertSame($contactHistoryEntity->getMessage(), $result->getMessage());
        $this->assertSame($contactHistoryEntity->getCreatedAt()->format('Y-m-d H:i:s'), $result->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @throws ReflectionException
     */
    public function testDeleteContactHistoryWhenSuccess(): void
    {
        $contactHistoryEntity = TestDataProvider::contactHistoryEntity();

        $this->contactHistoryRepositoryMock->expects($this->once())
            ->method('find')
            ->with($contactHistoryEntity->getId())
            ->willReturn($contactHistoryEntity);

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($contactHistoryEntity);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->contactHistoryService->deleteContactHistory($contactHistoryEntity->getId());
    }
}
