<?php

namespace App\Tests\Mapper;

use App\Mapper\ProjectMapper;
use App\Mapper\SkillMapper;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException as ReflectionExceptionAlias;

class ProjectMapperTest extends BaseTestCase
{
    private MockObject $projectRepositoryMock;
    private MockObject $skillRepositoryMock;
    private ProjectMapper $projectMapper;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $this->skillRepositoryMock = $this->createMock(SkillRepository::class);

        $this->projectMapper = new ProjectMapper(
            $this->projectRepositoryMock,
            new SkillMapper($this->skillRepositoryMock),
            $this->skillRepositoryMock);
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testDtoToEntityConversionWhenSuccessfully()
    {
        $projectDto = TestDataProvider::projectRequestDto();
        $projectEntity = TestDataProvider::projectEntity();

        $this->projectRepositoryMock->expects($this->once())
            ->method('find')
            ->with($projectEntity->getId())
            ->willReturn($projectEntity);

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($projectEntity->getSkills()->first()->getId())
            ->willReturn($projectEntity->getSkills()->first());

        $result = $this->projectMapper->dtoToEntity($projectDto, $projectEntity->getId());

        $this->assertSame($projectEntity->getId(), $result->getId());
        $this->assertSame($projectDto->getName(), $result->getName());
        $this->assertSame($projectDto->getDescription(), $result->getDescription());
        $this->assertSame($projectDto->getGithubLink(), $result->getGithubLink());
        $this->assertSame($projectDto->getDemoLink(), $result->getDemoLink());
        $this->assertSame($projectDto->getPictureUrl(), $result->getPictureUrl());
        $this->assertSame($projectDto->getDisplayOrder(), $result->getDisplayOrder());
        $this->assertCount(1, $result->getSkills());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testEntityToDtoConversionWhenSuccessfully()
    {
        $projectEntity = TestDataProvider::projectEntity();

        $result = $this->projectMapper->entityToDto($projectEntity);

        $this->assertSame($projectEntity->getId(), $result->getId());
        $this->assertSame($projectEntity->getName(), $result->getName());
        $this->assertSame($projectEntity->getDescription(), $result->getDescription());
        $this->assertSame($projectEntity->getGithubLink(), $result->getGithubLink());
        $this->assertSame($projectEntity->getDemoLink(), $result->getDemoLink());
        $this->assertSame($projectEntity->getPictureUrl(), $result->getPictureUrl());
        $this->assertSame($projectEntity->getDisplayOrder(), $result->getDisplayOrder());
        $this->assertCount(1, $result->getSkills());
    }
}
