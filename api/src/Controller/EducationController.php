<?php

namespace App\Controller;

use App\Dto\EducationRequestDto;
use App\Dto\UpdateOrderRequestDto;
use App\Service\EducationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class EducationController extends AbstractController
{
    #[Route('/api/admin/education/update-order', name: 'app_update_education_order', methods: ['PATCH'])]
    public function updateEducationOrder(
        #[MapRequestPayload(type: UpdateOrderRequestDto::class)] array $requestDto,
        EducationService $educationService): JsonResponse
    {
        $educationService->updateEducationOrder($requestDto);

        return $this->json(null, Response::HTTP_OK);
    }

    #[Route('/api/admin/education', name: 'app_create_education', methods: ['POST'])]
    public function createEducation(
        #[MapRequestPayload(validationGroups: ['education:create'])] EducationRequestDto $requestDto,
        EducationService $educationService): JsonResponse
    {
        $responseDto = $educationService->createEducation($requestDto);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }

    #[Route('/api/education/{id}', name: 'app_get_education', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getEducation(int $id, EducationService $educationService): JsonResponse
    {
        $responseDto = $educationService->getEducation($id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/education', name: 'app_get_all_educations', methods: ['GET'])]
    public function getAllEducations(EducationService $educationService): JsonResponse
    {
        $responseDto = $educationService->getAllEducations();

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/education/{id}', name: 'app_delete_education', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteEducation(int $id, EducationService $educationService): JsonResponse
    {
        $educationService->deleteEducation($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/admin/education/{id}', name: 'app_update_education', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateEducation(
        int $id,
        #[MapRequestPayload] EducationRequestDto $requestDto,
        EducationService $educationService): JsonResponse
    {
        $responseDto = $educationService->updateEducation($requestDto, $id);

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
