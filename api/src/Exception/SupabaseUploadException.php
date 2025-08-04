<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SupabaseUploadException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}
