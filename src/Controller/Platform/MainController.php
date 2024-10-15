<?php

namespace App\Controller\Platform;

use App\Entity\Platform\User;
use App\Repository\Platform\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'platform_main')]
    public function index(UserRepository $userRepository): Response
    {
        // get all users
        $users = $userRepository->findAll();

        return $this->render('platform/backend/base.html.twig', [
            'controller_name' => 'MainController',
            'users' => $users,
        ]);
    }
}
