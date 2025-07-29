<?php

namespace App\Tests\Service;

use App\Entity\Education;
use App\Mapper\EducationMapper;
use App\Repository\EducationRepository;
use App\Service\EducationService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class EducationServiceTest extends BaseTestCase
{
    private MockObject $entityManagerMock;
    private MockObject $educationRepositoryMock;
    private EducationService $educationService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->educationRepositoryMock = $this->createMock(EducationRepository::class);

        $this->educationService = new EducationService(
            $this->educationRepositoryMock,
            $this->entityManagerMock,
            new EducationMapper($this->educationRepositoryMock));
    }

    public function testCreateEducationCreatesEducationWhenSuccessful(): void
    {
        $educationDto = TestDataProvider::educationRequestDto();

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->willReturnCallback(function (Education $education) {
                $this->setProperty($education, 'id', 1);
            });

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->educationService->createEducation($educationDto);

        $this->assertNotNull($result->getId());
        $this->assertSame($educationDto->getInstitutionName(), $result->getInstitutionName());
        $this->assertSame($educationDto->getSpecialisation(), $result->getSpecialisation());
        $this->assertSame($educationDto->getStartDate(), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($educationDto->getEndDate(), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($educationDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetEducationsEducationsWhenSuccessful(): void
    {
        $education = TestDataProvider::educationEntity();

        $this->educationRepositoryMock->expects($this->once())
            ->method('find')
            ->with($education->getId())
            ->willReturn($education);

        $result = $this->educationService->getEducation($education->getId());

        $this->assertSame($education->getId(), $result->getId());
        $this->assertSame($education->getInstitutionName(), $result->getInstitutionName());
        $this->assertSame($education->getSpecialisation(), $result->getSpecialisation());
        $this->assertSame($education->getStartDate()->format('Y-m-d'), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($education->getEndDate()->format('Y-m-d'), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($education->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionException
     */
    public function testDeleteEducationDeletesEducationWhenSuccessful(): void
    {
        $education = TestDataProvider::educationEntity();

        $this->educationRepositoryMock->expects($this->once())
            ->method('find')
            ->with($education->getId())
            ->willReturn($education);

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($education);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->educationService->deleteEducation($education->getId());
    }

    /**
     * @throws ReflectionException
     */
    public function testUpdateEducationUpdatesEducationWhenSuccessful(): void
    {
        $education = TestDataProvider::educationEntity();
        $educationDto = TestDataProvider::educationRequestDto();

        $this->educationRepositoryMock->expects($this->once())
            ->method('find')
            ->with($education->getId())
            ->willReturn($education);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->educationService->updateEducation($educationDto, $education->getId());

        $this->assertSame($educationDto->getInstitutionName(), $result->getInstitutionName());
        $this->assertSame($educationDto->getSpecialisation(), $result->getSpecialisation());
        $this->assertSame($educationDto->getStartDate(), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($educationDto->getEndDate(), $result->getEndDate()->format('Y-m-d'));
        $this->assertNotNull($result->getDisplayOrder());
    }
}
