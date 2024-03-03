<?php

namespace App\Form\Invoice;

use App\Entity\TechcareInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TechcareQuotation;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
            ->add('amount', NumberType::class, [
                'label' => 'Montant',
                'scale' => 2,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le montant ne peut pas être vide.',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le montant doit être supérieur ou égal à 0.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez le montant de la facture',
                    'step' => '0.01',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TechcareInvoice::class,
            'quotations' => null,
        ]);
    }
}
