<?php

namespace App\Controller;

use App\Dto\ProfileRequestDto;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/api/admin/profile', name: 'app_edit_profile', methods: ['PATCH'])]
    public function editProfile(
        ProfileService $profileService,
        ProfileRequestDto $requestDto): JsonResponse
    {
        $responseDto = $profileService->editProfile($requestDto);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/profile', name: 'app_get_profile', methods: ['GET'])]
    public function getProfile(ProfileService $profileService): JsonResponse
    {
        $responseDto = $profileService->getProfile();

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
