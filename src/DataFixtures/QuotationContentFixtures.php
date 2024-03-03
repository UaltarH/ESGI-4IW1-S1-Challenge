<?php

namespace App\DataFixtures;

use App\Entity\TechcareQuotation;
use App\Entity\TechcareQuotationContent as QuotationContent;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class QuotationContentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $faker = Factory::create('fr_FR');

        $reparationPrix = 100;
        $diagnosticPrix = 200;
        $achatComposantsPrix = 300;
        $remplacementDePiecesPrix = 400;
        $nettoyagePrix = 500;
        $pateThermiquePrix = 600;
        $installationDeLogicielsPrix = 700;
        $changementDeBatteriePrix = 800;
        $filmProtecteurPrix = 900;

        $quotationCounter = $this->getReference("quotation-counter");
        $smartphoneCounter = $quotationCounter->getSmartphone();
        $computerCounter = $quotationCounter->getComputer();
        $tabletCounter = $quotationCounter->getTablet();

        for ($i = 1; $i <= $smartphoneCounter; $i++) {
            $quotation = $this->getReference("quotation-smartphone-$i");
            $total = 0;
            if ($i % 2 == 0) {
                $amount1 = $reparationPrix + $diagnosticPrix + $installationDeLogicielsPrix + $changementDeBatteriePrix;
                $amount2 = $reparationPrix + $nettoyagePrix;
                $content1 = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-iphone-15"))
                    ->setService($this->getReference("service-reparation"))
                    ->setService($this->getReference("service-diagnostic"))
                    ->setService($this->getReference("service-installation-de-logiciels"))
                    ->setService($this->getReference("service-changement-de-batterie"))
                    ->setAmount($amount1);

                $manager->persist($content1);
                $this->addReference("content-smartphone-quotation-$i-1", $content1);

                $content2 = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-iphone-15"))
                    ->setService($this->getReference("service-nettoyage"))
                    ->setService($this->getReference("service-reparation"))
                    ->setAmount($amount2);

                $manager->persist($content2);
                $this->addReference("content-smartphone-quotation-$i-2", $content2);
                $total = $amount1 + $amount2;
            } else {
                $total = $reparationPrix + $filmProtecteurPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-" . $faker->randomElement(['huawei', 'samsung']) . "-" . rand(1, 9)))
                    ->setService($this->getReference("service-reparation"))
                    ->setService($this->getReference("service-pose-de-film-protecteur"))
                    ->setAmount($total);


                $manager->persist($object);
                $this->addReference("content-smartphone-quotation-$i-1", $object);
            }
            $quotation->setAmount($total);

            $manager->getRepository(TechcareQuotation::class)->update($quotation);
            // TODO : continue here for all content
        }

        $cpt = 1;
        for ($i = 1; $i <= $computerCounter; $i++) {
            $quotation = $this->getReference("quotation-computer-$i");
            $total = 0;
            if ($cpt == 1) {
                $total = $nettoyagePrix + $pateThermiquePrix + $installationDeLogicielsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-lenovo-" . $faker->randomElement([100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800, 850, 900, 950, 1000])))
                    ->setService($this->getReference("service-nettoyage"))
                    ->setService($this->getReference("service-pate-thermique"))
                    ->setService($this->getReference("service-installation-de-logiciels"))
                    ->setAmount($total);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);
                $cpt++;
                $quotation->setAmount($total);

                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                continue;
            }
            if ($cpt == 2) {
                $amount1 = $diagnosticPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $amount2 = $installationDeLogicielsPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-5"))
                    ->setService($this->getReference("service-diagnostic"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setAmount($amount1);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-5"))
                    ->setService($this->getReference("service-installation-de-logiciels"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setAmount($amount2);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-2", $object);
                $total = $amount1 + $amount2;
                $quotation->setAmount($total);

                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt++;
                continue;
            }
            if ($cpt == 3) {
                $total = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-" . rand(1, 9)))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setService($this->getReference("service-reparation"))
                    ->setAmount($total);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);
                $quotation->setAmount($total);

                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt++;
                continue;
            }
            if ($cpt == 4) {
                $amount1 = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $amount2 = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $amount3 = $reparationPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setService($this->getReference("service-reparation"))
                    ->setAmount($amount1);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setService($this->getReference("service-reparation"))
                    ->setAmount($amount2);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-2", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->setService($this->getReference("service-reparation"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setAmount($amount3);

                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-3", $object);
                $total = $amount1 + $amount2 + $amount3;
                $quotation->setAmount($total);

                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt = 1;
            }
        }

        for ($i = 1; $i <= $tabletCounter; $i++) {
            $quotation = $this->getReference("quotation-tablet-$i");
            $total = 0;
            if ($i % 2 == 0) {
                $total = $diagnosticPrix + $nettoyagePrix + $remplacementDePiecesPrix + $changementDeBatteriePrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-tablette-" . rand(1, 9)))
                    ->setService($this->getReference("service-diagnostic"))
                    ->setService($this->getReference("service-nettoyage"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-changement-de-batterie"))
                    ->setService($this->getReference("service-achat-composants"))
                    ->setAmount($total);
            } else {
                $total = $reparationPrix + $nettoyagePrix + $remplacementDePiecesPrix + $filmProtecteurPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setProduct($this->getReference("product-tablette-" . rand(1, 9)))
                    ->setService($this->getReference("service-reparation"))
                    ->setService($this->getReference("service-nettoyage"))
                    ->setService($this->getReference("service-remplacement-de-pieces"))
                    ->setService($this->getReference("service-pose-de-film-protecteur"))
                    ->setAmount($total);
            }
            $manager->persist($object);
            $this->addReference("content-tablette-quotation-$i-1", $object);
            $quotation->setAmount($total);

            $manager->getRepository(TechcareQuotation::class)->update($quotation);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuotationFixtures::class,
            ProductFixtures::class,
            ServiceFixtures::class,
        ];
    }
}
