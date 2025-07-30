<?php

namespace App\Service;

use App\Dto\ProjectRequestDto;
use App\Dto\ProjectResponseDto;
use App\Entity\Project;
use App\Exception\ResourceAlreadyExistsException;
use App\Exception\ResourceNotFoundException;
use App\Mapper\ProjectMapper;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ProjectService
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private EntityManagerInterface $entityManager,
        private ProjectMapper $projectMapper
    )
    {
    }

    public function createProject(ProjectRequestDto $requestDto): ProjectResponseDto
    {
        if ($this->projectRepository->findOneBy(['name' => $requestDto->getName()])) {
            throw new ResourceAlreadyExistsException('Project already exists');
        }

        $project = $this->projectMapper->dtoToEntity($requestDto);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this->projectMapper->entityToDto($project);
    }

    public function getProject(int $id): ProjectResponseDto
    {
        $project = $this->projectRepository->find($id);

        if (null === $project) {
            throw new ResourceNotFoundException('Project not found');
        }

        return $this->projectMapper->entityToDto($project);
    }

    public function getAllProjects(): array
    {
        $projects = $this->projectRepository->findAll();

        return array_map(function (Project $project) {
            return $this->projectMapper->entityToDto($project);
        }, $projects);
    }

    public function deleteProject(int $id): void
    {
        $project = $this->projectRepository->find($id);

        if ($project) {
            $this->entityManager->remove($project);
            $this->entityManager->flush();
        }
    }

    public function updateProject(ProjectRequestDto $requestDto, int $id): ProjectResponseDto
    {
        $updatedProject = $this->projectMapper->dtoToEntity($requestDto, $id);
        $this->entityManager->flush();

        return $this->projectMapper->entityToDto($updatedProject);
    }
}
