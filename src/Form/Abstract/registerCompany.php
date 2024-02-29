<?php

namespace App\Form\Abstract;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Unique;

class registerCompany extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 50])
                ],
                'attr' => ['placeholder' => 'ex : John']
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'attr' => ['placeholder' => 'ex : Doe']
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                    new Email(),
                ],
                'attr' => ['placeholder' => 'ex : john.doe@exemple.com']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                    //todo: add password constraints
                ],
            ])
            ->add('companyName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1]),
                ],
                'attr' => ['placeholder' => 'ex : My Company Name']
            ])
            ->add('companySiret', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 14, 'max' => 14]),
                ],
                'attr' => ['placeholder' => 'ex : 123 456 789 12345']
            ])
            ->add('companyPhoneNumber', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1]),
                ],
                'attr' => ['placeholder' => 'ex : 0123456789']
            ])
            ->add('companyEmail', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                    new Email(),
                ],
                'attr' => ['placeholder' => 'ex : my.company@exemple.com']
            ])
            ->add('companyAddress', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'attr' => ['placeholder' => 'ex : 123 rue de la rue']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
