<?php

namespace App\Tests\Service;

use App\Entity\Education;
use App\Entity\WorkExperience;
use App\Mapper\EducationMapper;
use App\Mapper\WorkExperienceMapper;
use App\Repository\EducationRepository;
use App\Repository\WorkExperienceRepository;
use App\Service\EducationService;
use App\Service\WorkExperienceService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class WorkExperienceServiceTest extends BaseTestCase
{
    private MockObject $entityManagerMock;
    private MockObject $workExperienceRepositoryMock;
    private WorkExperienceService $workExperienceService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->workExperienceRepositoryMock = $this->createMock(WorkExperienceRepository::class);

        $this->workExperienceService = new WorkExperienceService(
            $this->workExperienceRepositoryMock,
            $this->entityManagerMock,
            new WorkExperienceMapper($this->workExperienceRepositoryMock));
    }

    public function testCreateWorkExperienceCreatesWorkExperienceWhenSuccessful(): void
    {
        $workExperienceDto = TestDataProvider::workExperienceRequestDto();

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->willReturnCallback(function (WorkExperience $workExperience) {
                $this->setProperty($workExperience, 'id', 1);
            });

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->workExperienceService->createWorkExperience($workExperienceDto);

        $this->assertNotNull($result->getId());
        $this->assertSame($workExperienceDto->getJobTitle(), $result->getJobTitle());
        $this->assertSame($workExperienceDto->getJobDescription(), $result->getJobDescription());
        $this->assertSame($workExperienceDto->getCompany(), $result->getCompany());
        $this->assertSame($workExperienceDto->getStartDate(), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getEndDate(), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetWorkExperienceReturnsWorkExperienceWhenSuccessful(): void
    {
        $workExperience = TestDataProvider::workExperienceEntity();

        $this->workExperienceRepositoryMock->expects($this->once())
            ->method('find')
            ->with($workExperience->getId())
            ->willReturn($workExperience);

        $result = $this->workExperienceService->getWorkExperience($workExperience->getId());

        $this->assertSame($workExperience->getId(), $result->getId());
        $this->assertSame($workExperience->getJobTitle(), $result->getJobTitle());
        $this->assertSame($workExperience->getJobDescription(), $result->getJobDescription());
        $this->assertSame($workExperience->getCompany(), $result->getCompany());
        $this->assertSame($workExperience->getStartDate()->format('Y-m-d'), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($workExperience->getEndDate()->format('Y-m-d'), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($workExperience->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionException
     */
    public function testDeleteWorkExperienceDeletesWorkExperienceWhenSuccessful(): void
    {
        $workExperience = TestDataProvider::educationEntity();

        $this->workExperienceRepositoryMock->expects($this->once())
            ->method('find')
            ->with($workExperience->getId())
            ->willReturn($workExperience);

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($workExperience);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->workExperienceService->deleteWorkExperience($workExperience->getId());
    }

    /**
     * @throws ReflectionException
     */
    public function testUpdateWorkExperienceUpdatesWorkExperienceWhenSuccessful(): void
    {
        $workExperience = TestDataProvider::workExperienceEntity();
        $workExperienceDto = TestDataProvider::workExperienceUpdateRequestDto();

        $this->workExperienceRepositoryMock->expects($this->once())
            ->method('find')
            ->with($workExperience->getId())
            ->willReturn($workExperience);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->workExperienceService->updateWorkExperience($workExperienceDto, $workExperience->getId());

        $this->assertSame($workExperience->getId(), $result->getId());
        $this->assertSame($workExperienceDto->getJobTitle(), $result->getJobTitle());
        $this->assertSame($workExperienceDto->getJobDescription(), $result->getJobDescription());
        $this->assertSame($workExperienceDto->getCompany(), $result->getCompany());
        $this->assertSame($workExperienceDto->getStartDate(), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getEndDate(), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getDisplayOrder(), $result->getDisplayOrder());
    }
}
