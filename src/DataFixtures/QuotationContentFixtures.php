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

        $reparationPrix = floatval($this->getReference("service-reparation")->getPrice());
        $diagnosticPrix = floatval($this->getReference("service-diagnostic")->getPrice());
        $achatComposantsPrix = floatval($this->getReference("service-achat-composants")->getPrice());
        $remplacementDePiecesPrix = floatval($this->getReference("service-remplacement-de-pieces")->getPrice());
        $nettoyagePrix = floatval($this->getReference("service-nettoyage")->getPrice());
        $pateThermiquePrix = floatval($this->getReference("service-pate-thermique")->getPrice());
        $installationDeLogicielsPrix = floatval($this->getReference("service-installation-de-logiciels")->getPrice());
        $changementDeBatteriePrix = floatval($this->getReference("service-changement-de-batterie")->getPrice());
        $filmProtecteurPrix = floatval($this->getReference("service-pose-de-film-protecteur")->getPrice());

        $quotationCounter = $this->getReference("quotation-counter");
        $smartphoneCounter = $quotationCounter->getSmartphone();
        $computerCounter = $quotationCounter->getComputer();
        $tabletCounter = $quotationCounter->getTablet();

        for($i = 1; $i<=$smartphoneCounter; $i++) {
            $quotation = $this->getReference("quotation-smartphone-$i");
            $total = 0;
            if($i%2==0) {
                $amount1 = $reparationPrix + $diagnosticPrix + $installationDeLogicielsPrix + $changementDeBatteriePrix;
                $amount2 = $reparationPrix + $nettoyagePrix;
                $content1 = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Smartphone ne s'allume plus. Changement de la batterie et installation de logiciels.")
                    ->setProduct($this->getReference("product-iphone-15"))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-diagnostic"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-installation-de-logiciels"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-changement-de-batterie"), 'json'))
                    ->setAmount($amount1)
                    ->setFinalAmount($amount1);
                $manager->persist($content1);
                $this->addReference("content-smartphone-quotation-$i-1", $content1);

                $content2 = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Vitre arrière iPhone cassée.")
                    ->setProduct($this->getReference("product-iphone-15"))
                    ->addService($serializer->serialize($this->getReference("service-nettoyage"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->setAmount($amount2)
                    ->setFinalAmount($amount2);
                $manager->persist($content2);
                $this->addReference("content-smartphone-quotation-$i-2", $content2);
                $total = $amount1+$amount2;
            }
            else {
                $total = $reparationPrix + $filmProtecteurPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Écran du smartphone cassé. Changement de la dalle et pose de film protecteur.")
                    ->setProduct($this->getReference("product-".$faker->randomElement(['huawei', 'samsung'])."-".rand(1, 9)))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-pose-de-film-protecteur"), 'json'))
                    ->setAmount($total)
                    ->setFinalAmount($total);

                $manager->persist($object);
                $this->addReference("content-smartphone-quotation-$i-1", $object);
            }
            $quotation->setAmount($total);
            $quotation->setFinalAmount($total);
            $manager->getRepository(TechcareQuotation::class)->update($quotation);
            // TODO : continue here for all content
        }

        $cpt = 1;
        for($i=1;$i<=$computerCounter;$i++) {
            $quotation = $this->getReference("quotation-computer-$i");
            $total = 0;
            if($cpt == 1) {
                $total = $nettoyagePrix + $pateThermiquePrix + $installationDeLogicielsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Ordinateur lent. Nettoyage et installation de logiciels.")
                    ->setProduct($this->getReference("product-lenovo-" . $faker->randomElement([100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800, 850, 900, 950, 1000])))
                    ->addService($serializer->serialize($this->getReference("service-nettoyage"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-pate-thermique"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-installation-de-logiciels"), 'json'))
                    ->setAmount($total)
                    ->setFinalAmount($total);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);
                $cpt++;
                $quotation->setAmount($total);
                $quotation->setFinalAmount($total);
                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                continue;
            }
            if($cpt == 2) {
                $amount1 = $diagnosticPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $amount2 = $installationDeLogicielsPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Ordinateur ne s'allume plus. Changement de l'alimentation.")
                    ->setProduct($this->getReference("product-macbook-5"))
                    ->addService($serializer->serialize($this->getReference("service-diagnostic"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->setAmount($amount1)
                    ->setFinalAmount($amount1);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Ordinateur ne s'allume plus. Changement de la carte mère.")
                    ->setProduct($this->getReference("product-macbook-5"))
                    ->addService($serializer->serialize($this->getReference("service-installation-de-logiciels"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->setAmount($amount2)
                    ->setFinalAmount($amount2);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-2", $object);
                $total = $amount1 + $amount2;
                $quotation->setAmount($total);
                $quotation->setFinalAmount($total);
                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt++;
                continue;
            }
            if($cpt == 3) {
                $total = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Touches clavier ordinateur cassées.")
                    ->setProduct($this->getReference("product-macbook-" . rand(1, 9)))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->setAmount($total)
                    ->setFinalAmount($total);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);
                $quotation->setAmount($total);
                $quotation->setFinalAmount($total);
                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt++;
                continue;
            }
            if($cpt == 4) {
                $amount1 = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $amount2 = $remplacementDePiecesPrix + $achatComposantsPrix + $reparationPrix;
                $amount3 = $reparationPrix + $remplacementDePiecesPrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Macbook Pro Touch Bar cassée.")
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->setAmount($amount1)
                    ->setFinalAmount($amount1);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-1", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Haut-parleurs Macbook Pro ne fonctionnent plus.")
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->setAmount($amount2)
                    ->setFinalAmount($amount2);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-2", $object);

                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Boitier Macbook Pro cassé.")
                    ->setProduct($this->getReference("product-macbook-8"))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->setAmount($amount3)
                    ->setFinalAmount($amount3);
                $manager->persist($object);
                $this->addReference("content-computer-quotation-$i-3", $object);
                $total = $amount1 + $amount2 + $amount3;
                $quotation->setAmount($total);
                $quotation->setFinalAmount($total);
                $manager->getRepository(TechcareQuotation::class)->update($quotation);
                $cpt = 1;
            }
        }

        for($i=1; $i<=$tabletCounter; $i++) {
            $quotation = $this->getReference("quotation-tablet-$i");
            $total = 0;
            if($i%2==0) {
                $total = $diagnosticPrix + $nettoyagePrix + $remplacementDePiecesPrix + $changementDeBatteriePrix + $achatComposantsPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Tablette ne s'allume plus après contact avec une boisson gazeuse.")
                    ->setProduct($this->getReference("product-tablette-".rand(1, 9)))
                    ->addService($serializer->serialize($this->getReference("service-diagnostic"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-nettoyage"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-changement-de-batterie"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-achat-composants"), 'json'))
                    ->setAmount($total)
                    ->setFinalAmount($total);
            }
            else {
                $total = $reparationPrix + $nettoyagePrix + $remplacementDePiecesPrix + $filmProtecteurPrix;
                $object = (new QuotationContent())
                    ->setQuotation($quotation)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setDescription("Tablette écran cassé. Changement de la dalle.")
                    ->setProduct($this->getReference("product-tablette-".rand(1, 9)))
                    ->addService($serializer->serialize($this->getReference("service-reparation"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-nettoyage"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-remplacement-de-pieces"), 'json'))
                    ->addService($serializer->serialize($this->getReference("service-pose-de-film-protecteur"), 'json'))
                    ->setAmount($total)
                    ->setFinalAmount($total);
            }
            $manager->persist($object);
            $this->addReference("content-tablette-quotation-$i-1", $object);
            $quotation->setAmount($total);
            $quotation->setFinalAmount($total);
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