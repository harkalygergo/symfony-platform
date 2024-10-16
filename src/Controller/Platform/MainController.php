<?php

namespace App\Controller\Platform;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends _PlatformController
{
    #[Route('/', name: 'platform_main')]
    public function start(): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        return $this->render('platform/backend/base.html.twig', $environment);
    }
}
