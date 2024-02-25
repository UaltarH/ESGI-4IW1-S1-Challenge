<?php

namespace App\Form\Product;

use App\Entity\TechcareBrand;
use App\Entity\TechcareComponent;
use App\Entity\TechcareProduct;
use App\Entity\TechcareProductCategory;
use Doctrine\DBAL\Types\TextType;
use Faker\Provider\ar_EG\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsAddAndUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
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
            ->add('release_year');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechcareProduct::class,
        ]);
    }
}
