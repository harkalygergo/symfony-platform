<?php

namespace App\Controller\Platform;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'platform_main')]
    public function index(): Response
    {
        return $this->render('platform/backend/base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}