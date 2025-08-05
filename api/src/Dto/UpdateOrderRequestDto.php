<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateOrderRequestDto
{
    public function __construct(
        #[SerializedName('id')]
        #[Assert\Type('integer')]
        private int $id,

        #[SerializedName('display_order')]
        #[Assert\Type('integer')]
        #[Assert\PositiveOrZero(message: 'Display order must be positive or zero')]
        private int $displayOrder,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }
}
