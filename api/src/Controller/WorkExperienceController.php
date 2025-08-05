<?php

namespace App\Controller;

use App\Dto\UpdateOrderRequestDto;
use App\Dto\WorkExperienceRequestDto;
use App\Service\WorkExperienceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class WorkExperienceController extends AbstractController
{
    #[Route('/api/admin/work-experience/update-order', name: 'app_work_experience_update_education_order', methods: ['PATCH'])]
    public function updateWorkExperienceOrder(
        #[MapRequestPayload(type: UpdateOrderRequestDto::class)] array $requestDto,
        WorkExperienceService $workExperienceService): JsonResponse
    {
        $workExperienceService->updateEducationOrder($requestDto);

        return $this->json(null, Response::HTTP_OK);
    }

    #[Route('/api/work-experience/{id}', name: 'app_get_work_experience', methods: ['GET'])]
    public function getWorkExperience(int $id, WorkExperienceService $workExperienceService): JsonResponse
    {
        $responseDto = $workExperienceService->getWorkExperience($id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/work-experience', name: 'app_get_all_work_experiences', methods: ['GET'])]
    public function getAllWorkExperiences(WorkExperienceService $workExperienceService): JsonResponse
    {
        $responseDto = $workExperienceService->getAllWorkExperiences();

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/work-experience', name: 'app_create_work_experience', methods: ['POST'])]
    public function createWorkExperience(
        #[MapRequestPayload(validationGroups: ['work-experience:create'])] WorkExperienceRequestDto $requestDto,
        WorkExperienceService $workExperienceService): JsonResponse
    {
        $responseDto = $workExperienceService->createWorkExperience($requestDto);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }

    #[Route('/api/admin/work-experience/{id}', name: 'app_update_work_experience', methods: ['PATCH'])]
    public function updateWorkExperience(
        #[MapRequestPayload] WorkExperienceRequestDto $requestDto,
        int $id,
        WorkExperienceService $workExperienceService): JsonResponse
    {
        $responseDto = $workExperienceService->updateWorkExperience($requestDto, $id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/work-experience/{id}', name: 'app_delete_work_experience', methods: ['DELETE'])]
    public function deleteWorkExperience(int $id, WorkExperienceService $workExperienceService): JsonResponse
    {
        $workExperienceService->deleteWorkExperience($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
