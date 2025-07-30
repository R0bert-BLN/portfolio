<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProjectRequestDto
{
    public function __construct(
        #[SerializedName('name')]
        #[Assert\NotBlank(message: 'Name is required', groups: ['project:create'])]
        private ?string $name,

        #[SerializedName('description')]
        #[Assert\NotBlank(message: 'Description is required', groups: ['project:create'])]
        private ?string $description,

        #[SerializedName('picture_url')]
        #[Assert\NotBlank(message: 'Picture URL is required', groups: ['project:create'])]
        private ?string $pictureUrl,

        #[SerializedName('github_link')]
        #[Assert\NotBlank(message: 'Github link is required', groups: ['project:create'])]
        private ?string $githubLink,

        #[SerializedName('demo_link')]
        private ?string $demoLink,

        #[SerializedName('display_order')]
        #[Assert\PositiveOrZero(message: 'Display order must be positive or zero')]
        private ?int $displayOrder,

        #[SerializedName('skills')]
        #[Assert\Count(min: 1, minMessage: 'At least one skill is required', groups: ['project:create'])]
        private array $skills = [],
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getGithubLink(): ?string
    {
        return $this->githubLink;
    }

    public function getDemoLink(): ?string
    {
        return $this->demoLink;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }
}
