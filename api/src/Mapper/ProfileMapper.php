<?php

namespace App\Mapper;

use App\Dto\ProfileRequestDto;
use App\Dto\ProfileResponseDto;
use App\Entity\Profile;
use App\Exception\ResourceNotFoundException;
use App\Repository\ProfileRepository;

readonly class ProfileMapper
{
    public function __construct(
        private ProfileRepository $profileRepository,
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

        if (null !== $profileRequestDto->getCvUrl()) {
            $profileEntity->setCvUrl($profileRequestDto->getCvUrl());
        }

        if (null !== $profileRequestDto->getPictureUrl()) {
            $profileEntity->setPictureUrl($profileRequestDto->getPictureUrl());
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
            $profileEntity->getId(),
            $profileEntity->getFirstName(),
            $profileEntity->getLastName(),
            $profileEntity->getJobTitle(),
            $profileEntity->getDescription(),
            $profileEntity->getCvUrl(),
            $profileEntity->getGithubLink(),
            $profileEntity->getLinkedinLink(),
            $profileEntity->getPictureUrl(),
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
