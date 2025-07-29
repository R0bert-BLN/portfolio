<?php

namespace App\Service;

use App\Dto\EducationRequestDto;
use App\Dto\EducationResponseDto;
use App\Exception\ResourceNotFoundException;
use App\Mapper\EducationMapper;
use App\Repository\EducationRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class EducationService
{
    public function __construct(
        private EducationRepository $educationRepository,
        private EntityManagerInterface $entityManager,
        private EducationMapper $educationMapper
    ) {}

    public function createEducation(EducationRequestDto $educationRequestDto): EducationResponseDto
    {
        $education = $this->educationMapper->dtoToEntity($educationRequestDto);

        $this->entityManager->persist($education);
        $this->entityManager->flush();

        return $this->educationMapper->entityToDto($education);
    }

    public function getEducation(int $id): EducationResponseDto
    {
        $education = $this->educationRepository->find($id);

        if (null === $education) {
            throw new ResourceNotFoundException('Education not found');
        }

        return $this->educationMapper->entityToDto($education);
    }

    public function deleteEducation(int $getId): void
    {
        $education = $this->educationRepository->find($getId);

        if ($education) {
            $this->entityManager->remove($education);
            $this->entityManager->flush();
        }
    }

    public function updateEducation(EducationRequestDto $educationRequestDto, int $id): EducationResponseDto
    {
        $education = $this->educationMapper->dtoToEntity($educationRequestDto, $id);
        $this->entityManager->flush();

        return $this->educationMapper->entityToDto($education);
    }
}
