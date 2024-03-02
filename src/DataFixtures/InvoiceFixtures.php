<?php

namespace App\DataFixtures;

use App\Enum\InvoiceStatus;
use App\Enum\QuotationStatus;
use App\Entity\TechcareInvoice as Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $paymentTotal = $this->getReference('payment-total')->getTotal();

        $invoiceCpt = 0;
        for ($i = 1; $i <= $paymentTotal; $i++) {
            $payment = $this->getReference('payment-' . $i);
            $quotation = $payment->getQuotation();
            if ($quotation->getStatus() !== QuotationStatus::paid->value) {
                $status = InvoiceStatus::not_paid->value;
            } else {
                $status = InvoiceStatus::paid->value;
            }
            $invoice = (new Invoice())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setAmount($payment->getAmount())
                ->setInvoiceNumber($payment->getQuotation()->getQuotationNumber())
                ->setPayment($payment)
                ->setQuotation($quotation)
                ->setClient($quotation->getClient())
                ->setStatus($status);
            $manager->persist($invoice);
            $this->addReference('invoice-' . ++$invoiceCpt, $invoice);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PaymentFixtures::class,
            QuotationContentFixtures::class,
            QuotationFixtures::class,
            ClientFixtures::class,
            CompanyFixtures::class,
        ];
    }
}
