<?php

namespace App\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[OA\Schema(schema: 'ProjectResponse')]
readonly class ProjectResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private int $id,

        #[SerializedName('name')]
        private string $name,

        #[SerializedName('description')]
        private string $description,

        #[SerializedName('picture_url')]
        private string $pictureUrl,

        #[SerializedName('github_link')]
        private string $githubLink,

        #[SerializedName('demo_link')]
        private ?string $demoLink,

        #[SerializedName('display_order')]
        private ?int $displayOrder,

        #[SerializedName('skills')]
        private array $skills,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }

    public function getDemoLink(): ?string
    {
        return $this->demoLink;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function getGithubLink(): string
    {
        return $this->githubLink;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }
}
