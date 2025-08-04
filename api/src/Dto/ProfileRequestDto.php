<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        #[SerializedName('cv')]
        private ?UploadedFile $cv = null,

        #[SerializedName('github_link')]
        private ?string $githubLink = null,

        #[SerializedName('linkedin_link')]
        private ?string $linkedinLink = null,

        #[SerializedName('picture')]
        private ?UploadedFile $picture = null,
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

    public function getCv(): ?UploadedFile
    {
        return $this->cv;
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

    public function getPicture(): ?UploadedFile
    {
        return $this->picture;
    }
}
