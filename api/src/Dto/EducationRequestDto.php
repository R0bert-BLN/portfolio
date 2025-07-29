<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class EducationRequestDto implements DtoInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Institution name is required', groups: ['education:create'])]
        #[SerializedName('institution_name')]
        private ?string $institutionName,

        #[Assert\NotBlank(message: 'Specialisation is required', groups: ['education:create'])]
        #[SerializedName('specialisation')]
        private ?string $specialisation,

        #[Assert\NotNull(message: 'Start date is required', groups: ['education:create'])]
        #[Assert\Date(message: 'Start date is invalid')]
        #[SerializedName('start_date')]
        private ?string $startDate,

        #[Assert\Date(message: 'End date is invalid')]
        #[SerializedName('end_date')]
        private ?string $endDate = null,

        #[Assert\PositiveOrZero(message: 'Display order must be positive or zero')]
        #[SerializedName('display_order')]
        private ?int $displayOrder = null,
    ) {
    }

    public function getInstitutionName(): ?string
    {
        return $this->institutionName;
    }

    public function getSpecialisation(): ?string
    {
        return $this->specialisation;
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
