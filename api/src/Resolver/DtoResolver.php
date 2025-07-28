<?php

namespace App\Resolver;

use App\Dto\DtoInterface;
use App\Exception\DtoValidationException;
use App\Exception\InvalidJsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class DtoResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (!$argumentType || !is_subclass_of($argumentType, DtoInterface::class)) {
            return [];
        }

        $context = [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false];

        try {
            $dto = $this->serializer->deserialize($request->getContent(), $argumentType, 'json', $context);
        } catch (\Exception) {
            throw new InvalidJsonException('Invalid JSON data.');
        }

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            throw new DtoValidationException('Validation failed.', $errors);
        }

        return [$dto];
    }
}
