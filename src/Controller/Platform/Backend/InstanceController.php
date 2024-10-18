<?php

namespace App\Controller\Platform\Backend;

use App\Controller\Platform\_PlatformController;
use App\Entity\Platform\Instance;
use App\Entity\Platform\User;
use App\Repository\Platform\InstanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted(User::ROLE_USER)]
class InstanceController extends _PlatformController
{
    // list instances for user
    #[Route('/{_locale}/admin/instance/', name: 'admin_list_user_instances')]
    public function listUserInstances(InstanceRepository $instanceRepository, Request $request): Response
    {
        $parameters = $this->getPlatformBasicEnviroments();

        $parameters['title'] = 'Instances';
        $parameters['tableHead'] = [
            'title' => 'Title',
            'owner' => 'Tulajdonos',
        ];

        $parameters['tableBody'] = $instanceRepository->findAll();

        return $this->render('platform/backend/list.html.twig', $parameters);
    }

    // list users for an instance
    #[Route('/{_locale}/admin/instance/{instance}/users/', name: 'admin_list_instance_users')]
    public function listInstanceUsers(UserInterface $user, Request $request, InstanceRepository $repository, Instance $instance): Response
    {
        // users and instances are many-to-many, find all users by instance
        $dataList = $instance->getUsers();

        $attributes = [
            'username' => 'Username',
            'fullName' => 'Full Name',
            'position' => 'Position',
            'roles' => 'Roles',
            'language' => 'Language',
            'status' => 'Status',
        ];

        $data = [
            'title' => 'Users',
            'dataList' => $dataList,
            'attributes' => $attributes,
        ];

        return $this->render('platform/backend/v1/list.html.twig', $data);
    }
}
