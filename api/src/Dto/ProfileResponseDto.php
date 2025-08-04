<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ProfileResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private int $id,

        #[SerializedName('first_name')]
        private string $firstName,

        #[SerializedName('last_name')]
        private string $lastName,

        #[SerializedName('job_title')]
        private string $jobTitle,

        #[SerializedName('description')]
        private string $description,

        #[SerializedName('cv_url')]
        private ?string  $cvUrl,

        #[SerializedName('github_link')]
        private string  $githubLink,

        #[SerializedName('linkedin_link')]
        private string  $linkedinLink,

        #[SerializedName('picture_url')]
        private ?string $pictureUrl,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCvUrl(): ?string
    {
        return $this->cvUrl;
    }

    public function getGithubLink(): string
    {
        return $this->githubLink;
    }

    public function getLinkedinLink(): string
    {
        return $this->linkedinLink;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }
}
