<?php

namespace App\Dto;

use App\Enum\SkillType;
use Symfony\Component\Serializer\Attribute\SerializedName;

class SkillResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        public int $id,

        #[SerializedName('name')]
        public string $name,

        #[SerializedName('type')]
        public SkillType $type,

        #[SerializedName('display_order')]
        public ?int $displayOrder
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): SkillType
    {
        return $this->type;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }
}
