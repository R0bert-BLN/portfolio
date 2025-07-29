<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class EducationResponseDto implements DtoInterface
{
    public function __construct(
        #[SerializedName('id')]
        private int $id,

        #[SerializedName('institution_name')]
        private string $institutionName,

        #[SerializedName('specialisation')]
        private string $specialisation,

        #[SerializedName('start_date')]
        private \DateTime $startDate,

        #[SerializedName('end_date')]
        private ?\DateTime $endDate = null,

        #[SerializedName('display_order')]
        private ?int $displayOrder = null,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInstitutionName(): string
    {
        return $this->institutionName;
    }

    public function getSpecialisation(): string
    {
        return $this->specialisation;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }
}
