<?php

namespace App\DataFixtures;

use App\Entity\PaymentMethod;
use App\Entity\QuotationCounter;
use App\Entity\QuotationStatus;
use App\Entity\TechcarePayment as Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $quotationCounter = $this->getReference('quotation-counter');
        $smartphoneQuoteCounter = $quotationCounter->getSmartphone();
        $computerQuoteCounter = $quotationCounter->getComputer();
        $tabletQuoteCounter = $quotationCounter->getTablet();

        $paymentCpt = 0;

        for ($i = 1; $i <= $smartphoneQuoteCounter; $i++) {
            $quotation = $this->getReference('quotation-smartphone-' . $i);
            if ($quotation->getStatus() !== QuotationStatus::paid->value)
                continue;
            $payment = (new Payment())
                ->setDate($faker->dateTime)
                ->setAmount($quotation->getAmount())
                ->setMethod($faker->randomElement(PaymentMethod::cases())->value)
                ->setPaymentNumber($faker->uuid)
                ->setClient($quotation->getClient())
                ->setQuotation($quotation);
            $manager->persist($payment);
            $this->addReference('payment-' . ++$paymentCpt, $payment);
        }

        for ($i = 1; $i <= $computerQuoteCounter; $i++) {
            $quotation = $this->getReference('quotation-computer-' . $i);
            if ($quotation->getStatus() !== QuotationStatus::paid->value)
                continue;
            $payment = (new Payment())
                ->setDate($faker->dateTime)
                ->setAmount($quotation->getAmount())
                ->setMethod($faker->randomElement(PaymentMethod::cases())->value)
                ->setPaymentNumber($faker->uuid)
                ->setClient($quotation->getClient())
                ->setQuotation($quotation);
            $manager->persist($payment);
            $this->addReference('payment-' . ++$paymentCpt, $payment);
        }

        for ($i = 1; $i <= $tabletQuoteCounter; $i++) {
            $quotation = $this->getReference('quotation-tablet-' . $i);
            if ($quotation->getStatus() !== QuotationStatus::paid->value)
                continue;
            $payment = (new Payment())
                ->setDate($faker->dateTime)
                ->setAmount($quotation->getAmount())
                ->setMethod($faker->randomElement(PaymentMethod::cases())->value)
                ->setPaymentNumber($faker->uuid)
                ->setClient($quotation->getClient())
                ->setQuotation($quotation);
            $manager->persist($payment);
            $this->addReference('payment-' . ++$paymentCpt, $payment);
        }
        $paymentTotal = new QuotationCounter();
        $paymentTotal->setTotal($paymentCpt);
        $this->addReference('payment-total', $paymentTotal);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuotationContentFixtures::class,
            QuotationFixtures::class,
            ClientFixtures::class,
            CompanyFixtures::class,
        ];
    }
}
