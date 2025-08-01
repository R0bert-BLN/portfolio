<?php

namespace App\Mapper;

use App\Dto\ProjectRequestDto;
use App\Dto\ProjectResponseDto;
use App\Entity\Project;
use App\Entity\Skill;
use App\Exception\ResourceNotFoundException;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;

readonly class ProjectMapper
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private SkillMapper $skillMapper,
        private SkillRepository $skillRepository,
    ) {
    }

    public function dtoToEntity(ProjectRequestDto $requestDto, ?int $id = null): Project
    {
        $project = $this->getProjectEntity($id);

        if ($requestDto->getName()) {
            $project->setName($requestDto->getName());
        }

        if ($requestDto->getDescription()) {
            $project->setDescription($requestDto->getDescription());
        }

        if ($requestDto->getGithubLink()) {
            $project->setGithubLink($requestDto->getGithubLink());
        }

        if ($requestDto->getDemoLink()) {
            $project->setDemoLink($requestDto->getDemoLink());
        }

        if ($requestDto->getPictureUrl()) {
            $project->setPictureUrl($requestDto->getPictureUrl());
        }

        if ($requestDto->getDisplayOrder()) {
            $project->setDisplayOrder($requestDto->getDisplayOrder());
        }

        if ($requestDto->getSkills()) {
            $project->getSkills()->clear();

            foreach ($requestDto->getSkills() as $skillId) {
                $project->addSkill($this->getSkillEntity($skillId));
            }
        }

        return $project;
    }

    public function entityToDto(Project $project): ProjectResponseDto
    {
        return new ProjectResponseDto(
            id: $project->getId(),
            name: $project->getName(),
            description: $project->getDescription(),
            pictureUrl: $project->getPictureUrl(),
            githubLink: $project->getGithubLink(),
            demoLink: $project->getDemoLink(),
            displayOrder: $project->getDisplayOrder(),
            skills: array_map(fn (Skill $skill) => $this->skillMapper->entityToDto($skill), $project->getSkills()->toArray())
        );
    }

    private function getProjectEntity(?int $id): Project
    {
        if (null === $id) {
            return new Project();
        }

        $project = $this->projectRepository->find($id);

        if (null === $project) {
            throw new ResourceNotFoundException('Project not found');
        }

        return $project;
    }

    private function getSkillEntity(int $id): Skill
    {
        $skill = $this->skillRepository->find($id);

        if (!$skill) {
            throw new ResourceNotFoundException('Skill not found');
        }

        return $skill;
    }
}
