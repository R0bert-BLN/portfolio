<?php

namespace App\Service;

use App\Dto\UpdateOrderRequestDto;
use App\Dto\WorkExperienceRequestDto;
use App\Dto\WorkExperienceResponseDto;
use App\Entity\WorkExperience;
use App\Exception\ResourceNotFoundException;
use App\Mapper\WorkExperienceMapper;
use App\Repository\WorkExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class WorkExperienceService
{
    public function __construct(
        private WorkExperienceRepository $workExperienceRepository,
        private EntityManagerInterface $entityManager,
        private WorkExperienceMapper $workExperienceMapper,
    ) {
    }

    public function createWorkExperience(WorkExperienceRequestDto $workExperienceDto): WorkExperienceResponseDto
    {
        $workExperience = $this->workExperienceMapper->dtoToEntity($workExperienceDto);

        $this->entityManager->persist($workExperience);
        $this->entityManager->flush();

        return $this->workExperienceMapper->entityToDto($workExperience);
    }

    public function updateWorkExperience(WorkExperienceRequestDto $workExperienceDto, int $id): WorkExperienceResponseDto
    {
        $workExperience = $this->workExperienceMapper->dtoToEntity($workExperienceDto, $id);

        $this->entityManager->flush();

        return $this->workExperienceMapper->entityToDto($workExperience);
    }

    public function deleteWorkExperience(int $id): void
    {
        $workExperience = $this->workExperienceRepository->find($id);

        if ($workExperience) {
            $this->entityManager->remove($workExperience);
            $this->entityManager->flush();
        }
    }

    public function getAllWorkExperiences(): array
    {
        $workExperiences = $this->workExperienceRepository->findBy([], ['displayOrder' => 'ASC']);

        return array_map(fn (WorkExperience $workExperience) => $this->workExperienceMapper->entityToDto($workExperience), $workExperiences);
    }

    public function getWorkExperience(int $id): WorkExperienceResponseDto
    {
        $workExperience = $this->workExperienceRepository->find($id);

        if (!$workExperience) {
            throw new ResourceNotFoundException('Work experience not found');
        }

        return $this->workExperienceMapper->entityToDto($workExperience);
    }

    /**
     * @param UpdateOrderRequestDto[] $requestDto
     */
    public function updateEducationOrder(array $requestDto): void
    {
        foreach ($requestDto as $orderDto) {
            $workExperience = $this->workExperienceRepository->find($orderDto->getId());

            if ($workExperience) {
                $workExperience->setDisplayOrder($orderDto->getDisplayOrder());
            }
        }

        $this->entityManager->flush();
    }
}
