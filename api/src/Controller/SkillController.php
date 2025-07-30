<?php

namespace App\Controller;

use App\Dto\SkillRequestDto;
use App\Service\SkillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class SkillController extends AbstractController
{
    #[Route('/api/skill/{id}', name: 'app_get_skill', methods: ['GET'])]
    public function getSkill(int $id, SkillService $skillService): JsonResponse
    {
        $responseDto = $skillService->getSkill($id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/skill', name: 'app_get_all_skills', methods: ['GET'])]
    public function getAllSkills(SkillService $skillService): JsonResponse
    {
        $responseDto = $skillService->getAllSkills();

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/skill/{id}', name: 'app_delete_skill', methods: ['DELETE'])]
    public function deleteSkill(int $id, SkillService $skillService): JsonResponse
    {
        $skillService->deleteSkill($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/admin/skill', name: 'app_create_skill', methods: ['POST'])]
    public function createSkill(
        #[MapRequestPayload(validationGroups: ['skill:create'])] SkillRequestDto $requestDto,
        SkillService $skillService): JsonResponse
    {
        $responseDto = $skillService->createSkill($requestDto);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }

    #[Route('/api/admin/skill/{id}', name: 'app_update_skill', methods: ['PATCH'])]
    public function updateSkill(
        int $id,
        #[MapRequestPayload] SkillRequestDto $requestDto,
        SkillService $skillService): JsonResponse
    {
        $responseDto = $skillService->updateSkill($requestDto, $id);

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
