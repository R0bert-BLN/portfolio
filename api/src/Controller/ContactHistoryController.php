<?php

namespace App\Controller;

use App\Dto\ContactHistoryRequestDto;
use App\Service\ContactHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ContactHistoryController extends AbstractController
{
    #[Route('/api/admin/contact-history/{id}', name: 'app_get_contact_history', methods: ['GET'])]
    public function getContactHistory(int $id, ContactHistoryService $contactHistoryService): JsonResponse
    {
        $responseDto = $contactHistoryService->getContactHistory($id);

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('api/admin/contact-history', name: 'app_get_all_contact_history', methods: ['GET'])]
    public function getAllContactHistory(ContactHistoryService $contactHistoryService): JsonResponse
    {
        $responseDto = $contactHistoryService->getAllContactHistories();

        return $this->json($responseDto, Response::HTTP_OK);
    }

    #[Route('/api/contact-history', name: 'app_create_contact_history', methods: ['POST'])]
    public function createContactHistory(
        #[MapRequestPayload] ContactHistoryRequestDto $requestDto,
        ContactHistoryService $contactHistoryService): JsonResponse
    {
        $responseDto = $contactHistoryService->createContactHistory($requestDto);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }

    #[Route('/api/admin/contact-history/{id}', name: 'app_delete_contact_history', methods: ['DELETE'])]
    public function deleteContactHistory(int $id, ContactHistoryService $contactHistoryService): JsonResponse
    {
        $contactHistoryService->deleteContactHistory($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
