<?php

namespace App\Form\User;

use App\Entity\TechcareUser;
use App\Entity\TechcareCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class AdminCreateOrUpdateUserFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => $options['role_choices'],
                'multiple' => false,
                'expanded' => false,
                'mapped' => false,
            ])
            ->add('firstname')
            ->add('lastname');

        if ($options['new'] == true) {
            $builder
                ->add('company', EntityType::class, [
                    'class' => TechcareCompany::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionnez une entreprise',
                ])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechcareUser::class,
            'role_choices' => [],
            'new' => true
        ]);
    }
}
