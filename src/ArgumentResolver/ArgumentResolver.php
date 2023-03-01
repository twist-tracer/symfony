<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;

class ArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @throws Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== Argument::class) {
            return [];
        }

        $violations = $this->validator->validate(
            $request->toArray(),
            new Assert\Collection([
                'id' => new Assert\Type('integer',),
                'name' => new Assert\Type('string')
            ])
        );

        if ($violations->count() > 0) {
            throw new Exception('Invalid Data');
        }

        yield $this->serializer->denormalize($request->toArray(), Argument::class);
    }
}
