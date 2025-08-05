<?php

namespace App\Mapper;

use App\Dto\ProfileRequestDto;
use App\Dto\ProfileResponseDto;
use App\Entity\Profile;
use App\Exception\ResourceNotFoundException;
use App\Exception\SupabaseUploadException;
use App\Repository\ProfileRepository;
use App\Service\SupabaseService;

readonly class ProfileMapper
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private SupabaseService $supabaseService,
    ) {
    }

    public function toEntity(ProfileRequestDto $profileRequestDto, ?int $profileId = null): Profile
    {
        $profileEntity = $this->getProfile($profileId);

        if (null !== $profileRequestDto->getFirstName()) {
            $profileEntity->setFirstName($profileRequestDto->getFirstName());
        }

        if (null !== $profileRequestDto->getLastName()) {
            $profileEntity->setLastName($profileRequestDto->getLastName());
        }

        if (null !== $profileRequestDto->getJobTitle()) {
            $profileEntity->setJobTitle($profileRequestDto->getJobTitle());
        }

        if (null !== $profileRequestDto->getDescription()) {
            $profileEntity->setDescription($profileRequestDto->getDescription());
        }

        if (null !== $profileRequestDto->getCv()) {
            $path = "documents/{$profileEntity->getFirstName()} {$profileEntity->getLastName()}.{$profileRequestDto->getCv()->guessExtension()}";

            try {
                $supabasePath = $this->supabaseService->uploadFile($profileRequestDto->getCv(), $path);
            } catch (SupabaseUploadException $e) {
                throw new SupabaseUploadException('Error uploading file to Supabase: '.$e->getMessage());
            }

            $profileEntity->setCvUrl($supabasePath);
        }

        if (null !== $profileRequestDto->getPicture()) {
            $path = "pictures/{$profileEntity->getId()}.{$profileRequestDto->getPicture()->guessExtension()}";

            try {
                $supabasePath = $this->supabaseService->uploadFile($profileRequestDto->getPicture(), $path);
            } catch (SupabaseUploadException $e) {
                throw new SupabaseUploadException('Error uploading file to Supabase: '.$e->getMessage());
            }

            $profileEntity->setPictureUrl($supabasePath);
        }

        if (null !== $profileRequestDto->getGithubLink()) {
            $profileEntity->setGithubLink($profileRequestDto->getGithubLink());
        }

        if (null !== $profileRequestDto->getLinkedinLink()) {
            $profileEntity->setLinkedinLink($profileRequestDto->getLinkedinLink());
        }

        return $profileEntity;
    }

    public function toDto(Profile $profileEntity): ProfileResponseDto
    {
        return new ProfileResponseDto(
            id: $profileEntity->getId(),
            firstName: $profileEntity->getFirstName(),
            lastName: $profileEntity->getLastName(),
            jobTitle: $profileEntity->getJobTitle(),
            description: $profileEntity->getDescription(),
            cvUrl: $profileEntity->getCvUrl(),
            githubLink: $profileEntity->getGithubLink(),
            linkedinLink: $profileEntity->getLinkedinLink(),
            pictureUrl: $profileEntity->getPictureUrl()
        );
    }

    private function getProfile(?int $profileId): Profile
    {
        if (null === $profileId) {
            return new Profile();
        }

        $profile = $this->profileRepository->find($profileId);

        if (null === $profile) {
            throw new ResourceNotFoundException('Profile not found');
        }

        return $profile;
    }
}
