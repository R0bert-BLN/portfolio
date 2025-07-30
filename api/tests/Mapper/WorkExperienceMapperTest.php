<?php

namespace App\Tests\Mapper;

use App\Mapper\WorkExperienceMapper;
use App\Repository\WorkExperienceRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException as ReflectionExceptionAlias;

class WorkExperienceMapperTest extends BaseTestCase
{
    private MockObject $workExperienceRepositoryMock;
    private WorkExperienceMapper $workExperienceMapper;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->workExperienceRepositoryMock = $this->createMock(WorkExperienceRepository::class);
        $this->workExperienceMapper = new WorkExperienceMapper($this->workExperienceRepositoryMock);
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testDtoToEntityConversionWhenSuccess(): void
    {
        $workExperienceDto = TestDataProvider::workExperienceRequestDto();
        $workExperienceEntity = TestDataProvider::workExperienceEntity();

        $this->workExperienceRepositoryMock->expects($this->once())
            ->method('find')
            ->with($workExperienceEntity->getId())
            ->willReturn($workExperienceEntity);

        $result = $this->workExperienceMapper->dtoToEntity($workExperienceDto, $workExperienceEntity->getId());

        $this->assertSame($workExperienceEntity->getId(), $result->getId());
        $this->assertSame($workExperienceDto->getCompany(), $result->getCompany());
        $this->assertSame($workExperienceDto->getJobTitle(), $result->getJobTitle());
        $this->assertSame($workExperienceDto->getStartDate(), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getEndDate(), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($workExperienceDto->getJobDescription(), $result->getJobDescription());
        $this->assertSame($workExperienceDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testEntityToDtoConversionWhenSuccessfully(): void
    {
        $workExperienceEntity = TestDataProvider::workExperienceEntity();

        $result = $this->workExperienceMapper->entityToDto($workExperienceEntity);

        $this->assertSame($workExperienceEntity->getId(), $result->getId());
        $this->assertSame($workExperienceEntity->getCompany(), $result->getCompany());
        $this->assertSame($workExperienceEntity->getJobTitle(), $result->getJobTitle());
        $this->assertSame($workExperienceEntity->getStartDate()->format('Y-m-d'), $result->getStartDate()->format('Y-m-d'));
        $this->assertSame($workExperienceEntity->getEndDate()->format('Y-m-d'), $result->getEndDate()->format('Y-m-d'));
        $this->assertSame($workExperienceEntity->getJobDescription(), $result->getJobDescription());
        $this->assertSame($workExperienceEntity->getDisplayOrder(), $result->getDisplayOrder());
    }
}
