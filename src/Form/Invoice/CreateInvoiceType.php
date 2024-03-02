<?php

namespace App\Form\Invoice;

use App\Entity\TechcareInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TechcareQuotation;

class CreateInvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quotation', EntityType::class, [
                'class' => TechcareQuotation::class,
                'choice_label' => 'quotation_number',
                'placeholder' => 'Sélectionnez un devis',
                'choices' => $options['quotations'],
                'mapped' => true,
            ])
            ->add('amount');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechcareInvoice::class,
            'quotations' => null,
        ]);
    }
}
