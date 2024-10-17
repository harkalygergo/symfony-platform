<?php

namespace App\Controller\Platform;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends _PlatformController
{
    #[Route('/proba', name: 'platform_main')]
    public function start(): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        return $this->render('platform/frontend/alpha/index.html.twig', $environment);
    }

    #[Route('/', name: 'platform_main')]
    #[Route('/wp-admin', name: 'platform_restricted')]
    public function restricted(): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        return $this->render('platform/backend/restricted.html.twig', $environment);
    }
}
