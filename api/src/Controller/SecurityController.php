<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class SecurityController extends AbstractController
{
    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage
    ): JsonResponse
    {
        $eventDispatcher->dispatch(new LogoutEvent($request, $tokenStorage->getToken()));

        return $this->json([
            'message' => 'Logged out successfully',
        ], Response::HTTP_OK);
    }
}
