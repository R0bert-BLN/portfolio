<?php

namespace App\Mapper;

use App\Dto\EducationRequestDto;
use App\Dto\EducationResponseDto;
use App\Entity\Education;
use App\Exception\ResourceNotFoundException;
use App\Repository\EducationRepository;

readonly class EducationMapper
{
    public function __construct(private EducationRepository $educationRepository)
    {
    }

    public function dtoToEntity(EducationRequestDto $educationRequestDto, ?int $educationId = null): Education
    {
        $education = $this->getEducation($educationId);

        if ($educationRequestDto->getInstitutionName()) {
            $education->setInstitutionName($educationRequestDto->getInstitutionName());
        }

        if ($educationRequestDto->getSpecialisation()) {
            $education->setSpecialisation($educationRequestDto->getSpecialisation());
        }

        if ($educationRequestDto->getStartDate()) {
            $education->setStartDate(date_create($educationRequestDto->getStartDate()));
        }

        if ($educationRequestDto->getEndDate()) {
            $education->setEndDate(date_create($educationRequestDto->getEndDate()));
        }

        if ($educationRequestDto->getDisplayOrder()) {
            $education->setDisplayOrder($educationRequestDto->getDisplayOrder());
        }

        return $education;
    }

    public function entityToDto(Education $education): EducationResponseDto
    {
        return new EducationResponseDto(
            id: $education->getId(),
            institutionName: $education->getInstitutionName(),
            specialisation: $education->getSpecialisation(),
            startDate: $education->getStartDate(),
            endDate: $education->getEndDate(),
            displayOrder: $education->getDisplayOrder(),
        );
    }

    private function getEducation(?int $id): Education
    {
        if (null === $id) {
            return new Education();
        }

        $education = $this->educationRepository->find($id);

        if (null === $education) {
            throw new ResourceNotFoundException('Education not found');
        }

        return $education;
    }
}
