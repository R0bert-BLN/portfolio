<?php

namespace App\Service;

use App\Dto\ProfileRequestDto;
use App\Dto\ProfileResponseDto;
use App\Exception\ResourceNotFoundException;
use App\Mapper\ProfileMapper;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ProfileService
{
    private const PROFILE_ID = 2;

    public function __construct(
        private ProfileRepository $profileRepository,
        private EntityManagerInterface $entityManager,
        private ProfileMapper $profileMapper)
    {
    }

    public function editProfile(ProfileRequestDto $requestDto): ProfileResponseDto
    {
        $profile = $this->profileMapper->toEntity($requestDto, self::PROFILE_ID);
        $this->entityManager->flush();

        return $this->profileMapper->toDto($profile);
    }

    public function getProfile(): ProfileResponseDto
    {
        $profile = $this->profileRepository->find(self::PROFILE_ID);

        if (!$profile) {
            throw new ResourceNotFoundException('Profile not found');
        }

        return $this->profileMapper->toDto($profile);
    }
}
