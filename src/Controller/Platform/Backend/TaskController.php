<?php

namespace App\Controller\Platform\Backend;

use App\Controller\Platform\_PlatformController;
use App\Entity\Platform\Task;
use App\Entity\Platform\User;
use App\Repository\Platform\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

//#[IsGranted(User::ROLE_USER)]
class TaskController extends _PlatformController
{
    #[Route('/{_locale}/admin/task/', name: 'admin_task')]
    public function index(TaskRepository $repository, Request $request): Response
    {
        $parameters = $this->getPlatformBasicEnviroments();

        $parameters['title'] = 'Feladatok';

        $parameters['tableHead'] = [
            'id'            => 'ID',
            'title'         => 'Cím',
            'description'   => 'Leírás'
        ];
        $parameters['tableBody'] = $repository->findAll();

        return $this->render('platform/backend/list.html.twig', $parameters);
    }

    #[Route('/{_locale}/admin/task/new/', name: 'admin_task_new')]
    public function new(Request $request, TranslatorInterface $translator)
    {
        $entity = new Task();

        $form = $this->createFormBuilder($entity)
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => $translator->trans('global.save'),
                'attr' => [
                    'class' => 'my-1 btn btn-lg btn-success'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Task $new */
            $new = $form->getData();
            $new->setCreatedAt(new \DateTimeImmutable('now')); // setting current date and time

            $em = $this->doctrine->getManager();
            $em->persist($new);
            $em->flush();

            $data['notification'] = $new->getTitle() . ' sikeresen létrehozva.';
        }

        $data = [
            'title' => '<i class="bi bi-list-task"></i> Feladatkezelő<hr>',
            'form' => $form,
        ];

        return $this->render('platform/backend/v1/form.html.twig', $data);
    }

    #[Route('/{_locale}/admin/task/edit/{id<\d+>}/', name: 'admin_task_edit')]
    public function edit(Request $request, Task $task)
    {
        $form = $this->createFormBuilder($task)
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Frissítés',
                'attr' => [
                    'class' => 'my-1 btn btn-lg btn-success'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $data['notification'] = $user->getTitle() . ' sikeresen létrehozva.';
        }

        $data = [
            'title' => '<i class="bi bi-list-task"></i> Feladatkezelő<hr>',
            'form' => $form,
        ];

        return $this->render('platform/backend/v1/form.html.twig', $data);    }
}
