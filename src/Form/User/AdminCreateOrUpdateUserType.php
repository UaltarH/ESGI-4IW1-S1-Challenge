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
use Symfony\Component\Form\CallbackTransformer;



class AdminCreateOrUpdateUserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => $options['role_choices'],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('firstname')
            ->add('lastname');

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            ));

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
