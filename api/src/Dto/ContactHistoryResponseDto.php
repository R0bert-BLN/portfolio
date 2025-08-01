<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ContactHistoryResponseDto
{
    public function __construct(
        #[SerializedName('id')]
        private int $id,

        #[SerializedName('name')]
        private string $name,

        #[SerializedName('email')]
        private string $email,

        #[SerializedName('message')]
        private string $message,

        #[SerializedName('created_at')]
        private \DateTime $createdAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
