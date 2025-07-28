<?php

namespace App\EventListener;

use App\Dto\ErrorResponseDto;
use App\Exception\DtoValidationException;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    #[NoReturn]
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $title = (new \ReflectionClass($exception))->getShortName();
        $message = $exception->getMessage();

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $responseDto = new ErrorResponseDto(
            $title,
            $message,
            $statusCode
        );

        if ($exception instanceof DtoValidationException) {
            $errors = [];

            foreach ($exception->getViolationList() as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $responseDto->setValidationErrors($errors);
        }

        $event->setResponse(new JsonResponse($responseDto, $statusCode));
    }
}
