<?php

namespace App\Form\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 50])
                ],
                'attr' => ['placeholder' => 'ex : John']
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2]),
                ],
                'attr' => ['placeholder' => 'ex : Doe']
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                    new Email(),
                ],
                'attr' => ['placeholder' => 'ex : john.doe@exemple.com',]
            ])
            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10]),
                ],
                'attr' => ['placeholder' => 'ex : 0123456789']
            ])
            ->add('billingAddress', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 7]),
                ],
                'attr' => ['placeholder' => 'ex : 1 rue de la rue']
            ]);
    }
}