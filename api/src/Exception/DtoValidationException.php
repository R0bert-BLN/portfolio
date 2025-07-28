<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class DtoValidationException extends HttpException
{
    public function __construct(
        string $message,
        private readonly ConstraintViolationListInterface $violationList)
    {
        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
