<?php

namespace App\Controller;

use App\Dto\LoginDto;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordEncoder
    ) {
    }


    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(#[MapRequestPayload]LoginDto $request, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['email' => $request->email]);
        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $request->password)) {
            throw new BadCredentialsException('Invalid credentials');
        }

        $token = $JWTManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
