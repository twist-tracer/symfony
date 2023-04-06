<?php

namespace App\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class Controller extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }

    public function public(): JsonResponse
    {
        return new JsonResponse(['user' => $this->security->getUser()]);
    }

    public function user(): JsonResponse
    {
        return new JsonResponse(['user' => $this->security->getUser()]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function admin(): JsonResponse
    {
        return new JsonResponse(['user' => $this->security->getUser()]);
    }
}
