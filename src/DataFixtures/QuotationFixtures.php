<?php

namespace App\DataFixtures;

use App\Entity\QuotationCounter;
use App\Entity\QuotationStatus;
use App\Entity\TechcareQuotation as Quotation;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuotationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // pour chaque client, on créé les mêmes devis : smartphone, ordinateur, tablette
        $smartphoneCpt = 0;
        $ordinateurCpt = 0;
        $tabletteCpt = 0;
        for($x = 0 ; $x<50 ; $x++) {
            $client = $this->getReference('client_' . $x);
            $company = $client->getCompany();
            for($i = 0 ; $i<2 ; $i++) {
                $invoiceNumber = $faker->year() . '-' . $faker->month . '-'
                    . $company->getCode() . '-' . $faker->uuid();
                $quotation = (new Quotation())
                    ->setQuotationNumber($invoiceNumber)
                    ->setAmount(0)
                    ->setDiscount(0)
                    ->setFinalAmount(0)
                    ->setStatus($faker->randomElement(QuotationStatus::cases())->value)
                    ->setCreatedBy("system")
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setClient($client);
                $manager->persist($quotation);
                $this->addReference('quotation-smartphone-'.++$smartphoneCpt, $quotation);
            }
            for($i = 0; $i<4; $i++) {
                $invoiceNumber = $faker->year() . '-' . $faker->month . '-'
                    . $company->getCode() . '-' . $faker->uuid();
                $quotation = (new Quotation())
                    ->setQuotationNumber($invoiceNumber)
                    ->setAmount(0)
                    ->setDiscount(0)
                    ->setFinalAmount(0)
                    ->setStatus($faker->randomElement(QuotationStatus::cases())->value)
                    ->setCreatedBy("system")
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setClient($client);
                $manager->persist($quotation);
                $this->addReference('quotation-computer-'.++$ordinateurCpt, $quotation);
            }
            for($i = 0; $i<2; $i++) {
                $invoiceNumber = $faker->year() . '-' . $faker->month . '-'
                    . $company->getCode() . '-' . $faker->uuid();
                $quotation = (new Quotation())
                    ->setQuotationNumber($invoiceNumber)
                    ->setAmount(0)
                    ->setDiscount(0)
                    ->setFinalAmount(0)
                    ->setStatus($faker->randomElement(QuotationStatus::cases())->value)
                    ->setCreatedBy("system")
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setClient($client);
                $manager->persist($quotation);
                $this->addReference('quotation-tablet-'.++$tabletteCpt, $quotation);
            }
        }
        $quotationCounter = new QuotationCounter();
        $quotationCounter->setSmartphone($smartphoneCpt);
        $quotationCounter->setComputer($ordinateurCpt);
        $quotationCounter->setTablet($tabletteCpt);
        $this->addReference('quotation-counter', $quotationCounter);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            CompanyFixtures::class,
        ];
    }
}