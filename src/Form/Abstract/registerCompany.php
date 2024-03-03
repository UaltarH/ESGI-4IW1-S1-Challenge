<?php

namespace App\Form\Abstract;

use App\Repository\TechcareUserRepository;
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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Regex;

class registerCompany extends AbstractType
{
    private TechcareUserRepository $userRepository;

    public function __construct(TechcareUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 50])
                ],
                'attr' => ['placeholder' => 'ex : John']
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'attr' => ['placeholder' => 'ex : Doe']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                    new Email(),
                ],
                'attr' => ['placeholder' => 'ex : john.doe@exemple.com'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre mot de passe ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom de votre entreprise',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de l\'entreprise ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le nom de votre entreprise doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de votre entreprise ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'attr' => ['placeholder' => 'ex : My Company Name']
            ])
            ->add('companySiret', TextType::class, [
                'label' => 'Siret',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro SIRET ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 14,
                        'max' => 14,
                        'exactMessage' => 'Le numéro SIRET doit comporter exactement {{ limit }} chiffres.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{14}$/',
                        'message' => 'Le numéro SIRET doit être composé uniquement de chiffres.',
                    ]),
                ],
                'attr' => ['placeholder' => 'ex : 123 456 789 12345']
            ])
            ->add('companyPhoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro de téléphone ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 15,
                        'minMessage' => 'Le numéro de téléphone doit comporter au moins {{ limit }} chiffres.',
                        'maxMessage' => 'Le numéro de téléphone ne peut pas dépasser {{ limit }} chiffres.',
                    ]),
                ],
                'attr' => ['placeholder' => 'ex : 0123456789']
            ])
            ->add('companyEmail', TextType::class, [
                'label' => 'Email de l\'entreprise',
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'email de l\'entreprise ne peut pas être vide.',
                    ]),
                    new Email([
                        'message' => 'L\'adresse email \'{{ value }}\' n\'est pas une adresse email valide.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 180,
                        'minMessage' => 'L\'email doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'email ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'attr' => ['placeholder' => 'ex : my.company@example.com']
            ])
            ->add('companyAddress', TextType::class, [
                'label' => 'Adresse de l\'entreprise',
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adresse de l\'entreprise ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'L\'adresse de l\'entreprise doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'adresse de l\'entreprise ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'attr' => ['placeholder' => 'ex : 123 rue de la rue']
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $existingUser = $this->userRepository->findOneBy(['email' => $data['email']]);
            if ($existingUser) {
                $form->get('email')->addError(new FormError('Cette email est déjà utilisé.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
