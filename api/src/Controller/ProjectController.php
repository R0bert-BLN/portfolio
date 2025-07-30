<?php

namespace App\Controller;

use App\Dto\ProjectRequestDto;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/api/project/{id}', name: 'app_get_project', methods: ['GET'])]
    public function getProject(int $id, ProjectService $projectService): JsonResponse
    {
        $responseDto = $projectService->getProject($id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/project', name: 'app_get_all_projects', methods: ['GET'])]
    public function getAllProjects(ProjectService $projectService): JsonResponse
    {
        $responseDto = $projectService->getAllProjects();

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/project/{id}', name: 'app_update_project', methods: ['PATCH'])]
    public function updateProject(
        #[MapRequestPayload] ProjectRequestDto $requestDto,
        int $id,
        ProjectService $projectService): JsonResponse
    {
        $responseDto = $projectService->updateProject($requestDto, $id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/admin/project', name: 'app_create_project', methods: ['POST'])]
    public function createProject(
        #[MapRequestPayload(validationGroups: ['project:create'])] ProjectRequestDto $requestDto,
        ProjectService $projectService): JsonResponse
    {
        $responseDto = $projectService->createProject($requestDto);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }

    #[Route('/api/admin/project/{id}', name: 'app_delete_project', methods: ['DELETE'])]
    public function deleteProject(int $id, ProjectService $projectService): JsonResponse
    {
        $projectService->deleteProject($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
