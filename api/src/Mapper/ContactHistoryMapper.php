<?php

namespace App\Mapper;

use App\Dto\ContactHistoryRequestDto;
use App\Dto\ContactHistoryResponseDto;
use App\Entity\ContactHistory;
use App\Exception\ResourceNotFoundException;
use App\Repository\ContactHistoryRepository;

readonly class ContactHistoryMapper
{
    public function __construct(private ContactHistoryRepository $contactHistoryRepository)
    {
    }

    public function dtoToEntity(ContactHistoryRequestDto $contactHistoryRequestDto, ?int $id = null): ContactHistory
    {
        $contactHistory = $this->getContactHistory($id);

        if ($contactHistoryRequestDto->getName()) {
            $contactHistory->setName($contactHistoryRequestDto->getName());
        }

        if ($contactHistoryRequestDto->getEmail()) {
            $contactHistory->setEmail($contactHistoryRequestDto->getEmail());
        }

        if ($contactHistoryRequestDto->getMessage()) {
            $contactHistory->setMessage($contactHistoryRequestDto->getMessage());
        }

        return $contactHistory;
    }

    public function entityToDto(ContactHistory $contactHistory): ContactHistoryResponseDto
    {
        return new ContactHistoryResponseDto(
            id: $contactHistory->getId(),
            name: $contactHistory->getName(),
            email: $contactHistory->getEmail(),
            message: $contactHistory->getMessage(),
            createdAt: $contactHistory->getCreatedAt()
        );
    }

    private function getContactHistory(?int $id): ContactHistory
    {
        if (!$id) {
            return new ContactHistory();
        }

        $contactHistory = $this->contactHistoryRepository->find($id);

        if (!$contactHistory) {
            throw new ResourceNotFoundException('Contact history not found');
        }

        return $contactHistory;
    }
}
