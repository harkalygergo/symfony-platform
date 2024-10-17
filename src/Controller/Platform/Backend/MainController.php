<?php

namespace App\Controller\Platform\Backend;

use App\Controller\Platform\_PlatformController;
use App\Repository\Platform\UserRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends _PlatformController
{
    #[Route('/{_locale}/admin/', name: 'admin_index')]
    public function index(): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        return $this->render('platform/backend/main.html.twig', $environment);
    }

    #[Route('/admin', name: 'admin_main')]
    public function start(UserRepository $userRepository): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        $environment['users'] = $userRepository->findAll();

        return $this->render('platform/backend/main.html.twig', $environment);
    }
}
