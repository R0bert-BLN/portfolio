<?php

namespace App\Service;

use App\Dto\SkillRequestDto;
use App\Dto\SkillResponseDto;
use App\Entity\Skill;
use App\Exception\ResourceAlreadyExistsException;
use App\Exception\ResourceNotFoundException;
use App\Mapper\SkillMapper;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class SkillService
{
    public function __construct(
        private SkillRepository $skillRepository,
        private EntityManagerInterface $entityManager,
        private SkillMapper $skillMapper
    )
    {
    }

    public function createSkill(SkillRequestDto $requestDto): SkillResponseDto
    {
        if ($this->skillRepository->findOneBy(['name' => $requestDto->name])) {
            throw new ResourceAlreadyExistsException('Skill with this name already exists');
        }

        $skill = $this->skillMapper->dtoToEntity($requestDto);

        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        return $this->skillMapper->entityToDto($skill);
    }

    public function getSkill(int $id): SkillResponseDto
    {
        $skill = $this->skillRepository->find($id);

        if (!$skill) {
            throw new ResourceNotFoundException('Skill not found');
        }

        return $this->skillMapper->entityToDto($skill);
    }

    public function getAllSkills(): array
    {
        $skills = $this->skillRepository->findAll();

        return array_map(function (Skill $skill) {
            return $this->skillMapper->entityToDto($skill);
        }, $skills);
    }

    public function updateSkill(SkillRequestDto $requestDto, int $id): SkillResponseDto
    {
        $updatedSkill = $this->skillMapper->dtoToEntity($requestDto, $id);

        $this->entityManager->flush();

        return $this->skillMapper->entityToDto($updatedSkill);
    }

    public function deleteSkill(int $id): void
    {
        $skill = $this->skillRepository->find($id);

        if ($skill) {
            $this->entityManager->remove($skill);
            $this->entityManager->flush();
        }
    }
}
