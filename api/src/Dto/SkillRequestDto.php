<?php

namespace App\Dto;

use App\Enum\SkillType;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SkillRequestDto
{
    public function __construct(
        #[SerializedName('name')]
        #[Assert\NotBlank(message: 'Name is required', groups: ['skill:create'])]
        public ?string $name,

        #[SerializedName('type')]
        #[Assert\NotBlank(message: 'Type is required', groups: ['skill:create'])]
        public ?SkillType $type,

        #[SerializedName('display_order')]
        #[Assert\Type(type: 'int', message: 'Display order must be an integer', groups: ['skill:create'])]
        public ?int $displayOrder = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?SkillType
    {
        return $this->type;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }
}
