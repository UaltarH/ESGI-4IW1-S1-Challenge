<?php

namespace App\Form\Product;

use App\Entity\TechcareBrand;
use App\Entity\TechcareComponent;
use App\Entity\TechcareProduct;
use App\Entity\TechcareProductCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsAddAndUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Nom du produit'],
            ])
            ->add('brand', EntityType::class, [
                'class' => TechcareBrand::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une marque',
            ])
            ->add('productCategory', EntityType::class, [
                'class' => TechcareProductCategory::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une catégorie de produit',
            ])
            ->add('components', EntityType::class, [
                'class' => TechcareComponent::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez des composants',
                'multiple' => true,
                'required' => false,
                'mapped' => true,
                'data' => $options['componentsList'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechcareProduct::class,
            'componentsList' => null,
        ]);
    }
}
