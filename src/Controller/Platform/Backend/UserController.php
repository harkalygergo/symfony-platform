<?php

namespace App\Controller\Platform\Backend;

use App\Controller\Platform\_PlatformController;
use App\Form\Platform\LoginType;
use App\Form\Platform\UserType;
use App\Repository\Platform\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends _PlatformController
{
    #[Route('/{_locale}/admin/user', name: 'admin_user')]
    public function index(UserRepository $userRepository): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        $environment['title'] = 'Felhasználók';
        $environment['tableHead'] = [
            'lastName'  => $this->translator->trans('user.lastName'),
            'firstName' => $this->translator->trans('user.firstName'),
            'email'     => $this->translator->trans('global.email'),
            'phone'     => $this->translator->trans('global.phone'),
            'status'    => $this->translator->trans('global.status'),
            'lastLogin' => $this->translator->trans('user.lastLogin'),
        ];
        $environment['tableBody'] = $userRepository->findAll();

        return $this->render('platform/backend/list.html.twig', $environment);
    }

    #[Route('/{_locale}/admin/user/instance', name: 'admin_user_instance')]
    public function adminUserInstances(UserRepository $userRepository): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        $instance = $userRepository->find(1)->getDefaultInstance();

        $environment['title'] = 'Instances';
        $environment['tableHead'] = [
            'title' => 'Title',
            'owner' => 'Tulajdonos',
        ];
        $environment['tableBody'] = $userRepository->getInstancesByUser(1);

        return $this->render('platform/backend/list.html.twig', $environment);
    }

    #[Route('/hu/belepes', name: 'admin_login_hu')]
    #[Route('/en/login', name: 'admin_login_en')]
    public function accountLogin(): Response
    {
        $data = $this->getPlatformBasicEnviroments();

        // use LoginType
        $form = $this->createForm(LoginType::class);

        $data += [
            'title' => '<i class="bi bi-box-arrow-in-right"></i> Bejelentkezés',
            'content' => '',
            'sidebar' => 'platform/backend/v1/sidebar_login.html.twig',
            'form' => $form
        ];

        return $this->render('platform/backend/login.html.twig', $data);
    }



    #[Route('/{_locale}/admin/account/edit', name: 'account_edit')]
    public function accountEdit(Request $request): Response
    {
        $user = $this->getUser();

        // create a form with the user data with UserType
        $form = $this->createForm(UserType::class, $user);


        /*
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('position', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('profileImageUrl', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => array_flip($user->getRoles()),
                'multiple' => true,
                'expanded' => true,
                'disabled' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('defaultInstance', EntityType::class, [
                'class' => Instance::class,
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control'
                ],
                'disabled' => true
            ])
            ->add('language', ChoiceType::class, [
                'choices'  => [
                    'english' => 'en',
                    'magyar' => 'hu',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => $translator->trans('global.save'),
                'attr' => [
                    'class' => 'my-2 btn btn-lg btn-success'
                ]
            ])
            ->getForm();
        */

        $data = $this->getPlatformBasicEnviroments();

        $data += [
            'title' => '<i class="bi bi-person"></i> Profil szerkesztése',
            'content' => '',
            'sidebar' => 'platform/backend/v1/sidebar_profile.html.twig',
            'form' => $form
        ];

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            // configure different hashers via the factory


            /*
            // verify that a given string matches the hash calculated above
            $hasher->verify($hash, 'invalid'); // false
            $hasher->verify($hash, 'plain'); // true

            $passwordHasherFactory = new PasswordHasherFactory([
                // auto hasher with default options for the User class (and children)
                User::class => ['algorithm' => 'auto'],

                // auto hasher with custom options for all PasswordAuthenticatedUserInterface instances
                PasswordAuthenticatedUserInterface::class => [
                    'algorithm' => 'auto',
                    'cost' => 15,
                ],
            ]);


            $hashedPassword = $passwordHasherFactory->getPasswordHasher($user)->hash('alma');
            */
            $hash = 'alma';
            $user->setPassword($hash);
            /*
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            */

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $data['notification'] = $user->getUsername(). ' felhasználó sikeresen létrehozva.';
        }

        return $this->render('platform/backend/form.html.twig', $data);
    }
}
