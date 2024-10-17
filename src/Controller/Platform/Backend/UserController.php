<?php

namespace App\Controller\Platform\Backend;

use App\Controller\Platform\_PlatformController;
use App\Form\Platform\UserType;
use App\Repository\Platform\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends _PlatformController
{
    #[Route('/{_locale}/admin/users', name: 'admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        $environment = $this->getPlatformBasicEnviroments();

        $environment['users'] = $userRepository->findAll();

        return $this->render('platform/backend/main.html.twig', $environment);
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