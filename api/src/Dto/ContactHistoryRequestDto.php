<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ContactHistoryRequestDto
{
    public function __construct(
        #[SerializedName('name')]
        #[Assert\NotBlank(message: 'Name is required')]
        private string $name,

        #[SerializedName('email')]
        #[Assert\NotBlank(message: 'Email is required')]
        #[Assert\Email(message: 'Email is invalid')]
        private string $email,

        #[SerializedName('message')]
        #[Assert\NotBlank(message: 'Message is required')]
        private string $message,
    )
    {
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
}
