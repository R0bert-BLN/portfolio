<?php

namespace App\Mapper;

use App\Dto\SkillRequestDto;
use App\Dto\SkillResponseDto;
use App\Entity\Skill;
use App\Exception\ResourceNotFoundException;
use App\Repository\SkillRepository;

readonly class SkillMapper
{
    public function __construct(
        private SkillRepository $skillRepository
    )
    {
    }

    public function dtoToEntity(SkillRequestDto $projectRequestDto, ?int $id = null): Skill
    {
        $skill = $this->getEntity($id);

        if ($projectRequestDto->getName()) {
            $skill->setName($projectRequestDto->getName());
        }

        if ($projectRequestDto->getType()) {
            $skill->setType($projectRequestDto->getType());
        }

        if ($projectRequestDto->getDisplayOrder()) {
            $skill->setDisplayOrder($projectRequestDto->getDisplayOrder());
        }

        return $skill;
    }

    public function entityToDto(Skill $skill): SkillResponseDto
    {
        return new SkillResponseDto(
            id: $skill->getId(),
            name:  $skill->getName(),
            type: $skill->getType(),
            displayOrder: $skill->getDisplayOrder()
        );
    }

    private function getEntity(?int $id): Skill
    {
        if (!$id) {
            return new Skill();
        }

        $skill = $this->skillRepository->find($id);

        if (!$skill) {
            throw new ResourceNotFoundException('Skill not found');
        }

        return $skill;
    }

}
