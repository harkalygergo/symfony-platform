<?php

namespace App\Form\Platform;

use App\Entity\Platform\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends _PlatformType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('global.identifier'),
                'attr' => [
                    'class' => 'form-control form-control-lg bg-dark text-white'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => $this->translator->trans('global.password'),
                'attr' => [
                    'class' => 'form-control form-control-lg bg-dark text-white'
                ]
            ])
            ->add('language', ChoiceType::class, [
                'label' => $this->translator->trans('global.language'),
                'choices'  => [
                    'english' => 'en',
                    'magyar' => 'hu',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg bg-dark text-white'
                ]
            ])
            ->add('_remember_me', CheckboxType::class, [
                'label' => $this->translator->trans('global.keepLoggedIn'),
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input bg-dark text-white'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('global.login'),
                'attr' => [
                    'class' => 'btn btn-outline-light btn-lg px-5 my-3'
                ]
            ])
            ;
    }
}
