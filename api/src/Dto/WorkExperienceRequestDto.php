<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class WorkExperienceRequestDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Job title is required', groups: ['work_experience:create'])]
        #[SerializedName('job_title')]
        private ?string $jobTitle,

        #[Assert\NotBlank(message: 'Job description is required', groups: ['work_experience:create'])]
        #[SerializedName('job_description')]
        private ?string $jobDescription,

        #[Assert\NotBlank(message: 'Company name is required', groups: ['work_experience:create'])]
        #[SerializedName('company')]
        private ?string $company,

        #[Assert\Date(message: 'Start date is invalid')]
        #[SerializedName('start_date')]
        private ?string $startDate,

        #[Assert\Date(message: 'End date is invalid')]
        #[SerializedName('end_date')]
        private ?string $endDate,

        #[Assert\PositiveOrZero(message: 'Display order must be positive or zero')]
        #[SerializedName('display_order')]
        private ?int $displayOrder,
    ) {
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
}
