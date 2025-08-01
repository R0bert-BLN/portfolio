<?php

namespace App\Tests\Service;

use App\Entity\Project;
use App\Exception\ResourceNotFoundException;
use App\Mapper\ProjectMapper;
use App\Mapper\SkillMapper;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Service\ProjectService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException as ReflectionExceptionAlias;

class ProjectServiceTest extends BaseTestCase
{
    private MockObject $projectRepositoryMock;
    private MockObject $entityManagerMock;
    private MockObject $skillRepositoryMock;
    private ProjectService $projectService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->skillRepositoryMock = $this->createMock(SkillRepository::class);

        $this->projectService = new ProjectService(
            $this->projectRepositoryMock,
            $this->entityManagerMock,
            new ProjectMapper(
                $this->projectRepositoryMock,
                new SkillMapper($this->skillRepositoryMock),
                $this->skillRepositoryMock));
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testCreateProjectCreatesProjectWhenSuccessful(): void
    {
        $projectDto = TestDataProvider::projectRequestDto();

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($projectDto->getSkills()[0])
            ->willReturn(TestDataProvider::skillEntity());

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->willReturnCallback(function (Project $project) {
                $this->setProperty($project, 'id', 1);

                foreach ($project->getSkills() as $index => $skill) {
                    $this->setProperty($skill, 'id', $index + 1);
                }
            });

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->projectService->createProject($projectDto);

        $this->assertSame(1, $result->getId());
        $this->assertSame($projectDto->getName(), $result->getName());
        $this->assertSame($projectDto->getDescription(), $result->getDescription());
        $this->assertSame($projectDto->getPictureUrl(), $result->getPictureUrl());
        $this->assertSame($projectDto->getGithubLink(), $result->getGithubLink());
        $this->assertSame($projectDto->getDemoLink(), $result->getDemoLink());
        $this->assertSame($projectDto->getDisplayOrder(), $result->getDisplayOrder());
        $this->assertCount(1, $result->getSkills());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testGetProjectReturnsProjectWhenSuccessful(): void
    {
        $project = TestDataProvider::projectEntity();

        $this->projectRepositoryMock->expects($this->once())
            ->method('find')
            ->with($project->getId())
            ->willReturn($project);

        $result = $this->projectService->getProject($project->getId());

        $this->assertSame($project->getId(), $result->getId());
        $this->assertSame($project->getName(), $result->getName());
        $this->assertSame($project->getDescription(), $result->getDescription());
        $this->assertSame($project->getPictureUrl(), $result->getPictureUrl());
        $this->assertSame($project->getGithubLink(), $result->getGithubLink());
        $this->assertSame($project->getDemoLink(), $result->getDemoLink());
        $this->assertSame($project->getDisplayOrder(), $result->getDisplayOrder());
    }

    public function testGetProjectThrowsResourceNotFoundExceptionWhenProjectNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->projectRepositoryMock->expects($this->once())
            ->method('find')
            ->with(2)
            ->willReturn(null);

        $this->projectService->getProject(2);
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testDeleteProjectDeletesProjectWhenSuccessful(): void
    {
        $project = TestDataProvider::projectEntity();

        $this->projectRepositoryMock->expects($this->once())
            ->method('find')
            ->with($project->getId())
            ->willReturn($project);

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($project);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->projectService->deleteProject($project->getId());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testUpdateEducationUpdatesEducationWhenSuccessful(): void
    {
        $project = TestDataProvider::projectEntity();
        $projectDto = TestDataProvider::projectRequestDto();

        $this->projectRepositoryMock->expects($this->once())
            ->method('find')
            ->with($project->getId())
            ->willReturn($project);

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($project->getSkills()->first()->getId())
            ->willReturn($project->getSkills()->first());

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->projectService->updateProject($projectDto, $project->getId());

        $this->assertSame($project->getId(), $result->getId());
        $this->assertSame($projectDto->getName(), $result->getName());
        $this->assertSame($projectDto->getDescription(), $result->getDescription());
        $this->assertSame($projectDto->getPictureUrl(), $result->getPictureUrl());
        $this->assertSame($projectDto->getGithubLink(), $result->getGithubLink());
        $this->assertSame($projectDto->getDemoLink(), $result->getDemoLink());
        $this->assertSame($projectDto->getDisplayOrder(), $result->getDisplayOrder());
    }
}
