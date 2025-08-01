<?php

namespace App\Dto;

class ErrorResponseDto implements \JsonSerializable
{
    public function __construct(
        private readonly string $title,

        private readonly string $message,

        private readonly int $statusCode,
        private ?array $validationErrors = null)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getValidationErrors(): ?array
    {
        return $this->validationErrors;
    }

    public function setValidationErrors(array $validationErrors): void
    {
        $this->validationErrors = $validationErrors;
    }

    public function jsonSerialize(): array
    {
        if (null === $this->validationErrors) {
            return [
                'title' => $this->title,
                'message' => $this->message,
                'status_code' => $this->statusCode,
            ];
        }

        return [
            'title' => $this->title,
            'message' => $this->message,
            'status_code' => $this->statusCode,
            'validation_errors' => $this->validationErrors,
        ];
    }
}
