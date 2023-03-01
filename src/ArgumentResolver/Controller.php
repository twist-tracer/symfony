<?php

namespace App\ArgumentResolver;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class Controller
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function index(Argument $argument): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($argument));
    }
}
