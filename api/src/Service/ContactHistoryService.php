<?php

namespace App\Service;

use App\Dto\ContactHistoryRequestDto;
use App\Dto\ContactHistoryResponseDto;
use App\Exception\ResourceNotFoundException;
use App\Mapper\ContactHistoryMapper;
use App\Repository\ContactHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContactHistoryService
{
    public function __construct(
        private ContactHistoryRepository $contactHistoryRepository,
        private EntityManagerInterface $entityManager,
        private ContactHistoryMapper $contactHistoryMapper
    ) {}

    public function createContactHistory(ContactHistoryRequestDto $contactHistoryDto): ContactHistoryResponseDto
    {
        $contactHistory = $this->contactHistoryMapper->dtoToEntity($contactHistoryDto);

        $this->entityManager->persist($contactHistory);
        $this->entityManager->flush();

        return $this->contactHistoryMapper->entityToDto($contactHistory);
    }

    public function deleteContactHistory(int $id): void
    {
        $contactHistory = $this->contactHistoryRepository->find($id);

        if ($contactHistory) {
            $this->entityManager->remove($contactHistory);
            $this->entityManager->flush();
        }
    }

    public function getContactHistory(int $id): ContactHistoryResponseDto
    {
        $contactHistory = $this->contactHistoryRepository->find($id);

        if (!$contactHistory) {
            throw new ResourceNotFoundException('Contact history not found');
        }

        return $this->contactHistoryMapper->entityToDto($contactHistory);
    }

    public function getAllContactHistories(): array
    {
        $contactHistories = $this->contactHistoryRepository->findAll();

        return array_map(function ($contactHistory) {
            return $this->contactHistoryMapper->entityToDto($contactHistory);
        }, $contactHistories);
    }
}
