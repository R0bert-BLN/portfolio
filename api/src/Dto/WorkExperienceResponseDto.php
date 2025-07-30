<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class WorkExperienceResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private int $id,

        #[SerializedName('job_title')]
        private string $jobTitle,

        #[SerializedName('job_description')]
        private string $jobDescription,

        #[SerializedName('company')]
        private string $company,

        #[SerializedName('start_date')]
        private \DateTime $startDate,

        #[SerializedName('end_date')]
        private ?\DateTime $endDate,

        #[SerializedName('display_order')]
        private ?int   $displayOrder)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function getJobDescription(): string
    {
        return $this->jobDescription;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }
}
