<?php

namespace App\Controller\Platform;

use App\Repository\Platform\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends _PlatformController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        $environment['users'] = $userRepository->findAll();

        return $this->render('platform/backend/main.html.twig', $environment);
    }
}
