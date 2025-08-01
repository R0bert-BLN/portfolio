<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ProfileRequestDto
{
    public function __construct(
        #[SerializedName('first_name')]
        private ?string $firstName = null,

        #[SerializedName('last_name')]
        private ?string $lastName = null,

        #[SerializedName('job_title')]
        private ?string $jobTitle = null,

        #[SerializedName('description')]
        private ?string $description = null,

        #[SerializedName('cv_url')]
        private ?string $cvUrl = null,

        #[SerializedName('github_link')]
        private ?string $githubLink = null,

        #[SerializedName('linkedin_link')]
        private ?string $linkedinLink = null,

        #[SerializedName('picture_url')]
        private ?string $pictureUrl = null,
    ) {
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getCvUrl(): ?string
    {
        return $this->cvUrl;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function getGithubLink(): ?string
    {
        return $this->githubLink;
    }

    public function getLinkedinLink(): ?string
    {
        return $this->linkedinLink;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }
}
