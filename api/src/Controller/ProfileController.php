<?php

namespace App\Controller;

use App\Dto\ProfileRequestDto;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/api/admin/profile', name: 'app_edit_profile', methods: ['PATCH', 'POST'])]
    public function editProfile(
        ProfileService $profileService,
        Request $request,
        #[MapRequestPayload] ProfileRequestDto $requestDto): JsonResponse
    {
        $dto = new ProfileRequestDto(
            firstName: $requestDto->getFirstName(),
            lastName: $requestDto->getLastName(),
            jobTitle: $requestDto->getJobTitle(),
            description: $requestDto->getDescription(),
            cv: $request->files->get('cv'),
            githubLink: $requestDto->getGithubLink(),
            linkedinLink: $requestDto->getLinkedinLink(),
            picture: $request->files->get('picture')
        );

        $responseDto = $profileService->editProfile($dto);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/profile', name: 'app_get_profile', methods: ['GET'])]
    public function getProfile(ProfileService $profileService): JsonResponse
    {
        $responseDto = $profileService->getProfile();

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
