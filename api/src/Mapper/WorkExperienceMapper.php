<?php

namespace App\Mapper;

use App\Dto\WorkExperienceRequestDto;
use App\Dto\WorkExperienceResponseDto;
use App\Entity\WorkExperience;
use App\Exception\ResourceNotFoundException;
use App\Repository\WorkExperienceRepository;

readonly class WorkExperienceMapper
{
    public function __construct(
        private WorkExperienceRepository $workExperienceRepository
    )
    {
    }

    public function dtoToEntity(WorkExperienceRequestDto $requestDto, ?int $id = null): WorkExperience
    {
        $workExperience = $this->getEntity($id);

        if ($requestDto->getCompany()) {
            $workExperience->setCompany($requestDto->getCompany());
        }

        if ($requestDto->getJobTitle()) {
            $workExperience->setJobTitle($requestDto->getJobTitle());
        }

        if ($requestDto->getJobDescription()) {
            $workExperience->setJobDescription($requestDto->getJobDescription());
        }

        if ($requestDto->getStartDate()) {
            $workExperience->setStartDate(date_create($requestDto->getStartDate()));
        }

        if ($requestDto->getEndDate()) {
            $workExperience->setEndDate(date_create($requestDto->getEndDate()));
        }

        if ($requestDto->getDisplayOrder()) {
            $workExperience->setDisplayOrder($requestDto->getDisplayOrder());
        }

        return $workExperience;
    }

    public function entityToDto(WorkExperience $workExperience): WorkExperienceResponseDto
    {
        return new WorkExperienceResponseDto(
            id: $workExperience->getId(),
            jobTitle: $workExperience->getJobTitle(),
            jobDescription: $workExperience->getJobDescription(),
            company: $workExperience->getCompany(),
            startDate: $workExperience->getStartDate(),
            endDate: $workExperience->getEndDate(),
            displayOrder: $workExperience->getDisplayOrder()
        );
    }

    private function getEntity(?int $id): WorkExperience
    {
        if (!$id) {
            return new WorkExperience();
        }

        $workExperience = $this->workExperienceRepository->find($id);

        if (!$workExperience) {
            throw new ResourceNotFoundException('Work experience not found');
        }

        return $workExperience;
    }
}
