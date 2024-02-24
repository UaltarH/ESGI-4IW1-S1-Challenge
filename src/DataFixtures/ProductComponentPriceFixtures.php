<?php

namespace App\DataFixtures;

use App\Entity\TechcareProductComponentPrice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductComponentPriceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 16; $i++) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-coque'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-camera-frontale'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($i > 12 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 8 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-volume'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-compartiment-sim'));
            $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-bouton-home'));
                $productComponentPrice->addProductId($this->getReference('product-iphone-' . $i));
                $manager->persist($productComponentPrice);
            }
        }




        for ($i = 1; $i < 24; $i++) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-coque'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-camera-frontale'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($i > 12 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 8 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-volume'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-compartiment-sim'));
            $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-bouton-home'));
                $productComponentPrice->addProductId($this->getReference('product-samsung-' . $i));
                $manager->persist($productComponentPrice);
            }
        }



        for ($i = 1; $i < 10; $i++) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-coque'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-camera-frontale'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($i > 12 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 8 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-volume'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-compartiment-sim'));
            $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 12) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-triple-ou-plus'));
                $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
                $manager->persist($productComponentPrice);
            } elseif ($i > 8) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-double'));
                $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
                $manager->persist($productComponentPrice);
            } else {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-simple'));
                $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
                $manager->persist($productComponentPrice);
            }

            if ($i > 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 10) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-bouton-home'));
                $productComponentPrice->addProductId($this->getReference('product-huawei-' . $i));
                $manager->persist($productComponentPrice);
            }
        }


        for ($i = 1; $i < 10; $i++) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-boitier'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-pave-tactile'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-usb'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-rj45'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-hdmi-dp-vga'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-webcam'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-clavier'));
            $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-prise-jack-audio-micro'));
                $productComponentPrice->addProductId($this->getReference('product-macbook-' . $i));
                $manager->persist($productComponentPrice);
            }
        }


        for ($i = 100; $i <= 1000; $i += 50) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-boitier'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-volume'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-camera-frontale'));
            $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-prise-jack-audio-micro'));
                $productComponentPrice->addProductId($this->getReference('product-lenovo-' . $i));
                $manager->persist($productComponentPrice);
            }
        }


        for ($i = 1; $i < 10; $i++) {
            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-ecran'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-coque'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-batterie'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-graphique'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-memoire'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-processeur'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-carte-mere'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-haut-parleurs'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-camera-frontale'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-de-charge'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-bouton-power'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-pave-tactile'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-usb'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-rj45'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-port-hdmi-dp-vga'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            $productComponentPrice = new TechcareProductComponentPrice();
            $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
            $productComponentPrice->addComponentId($this->getReference('component-webcam'));
            $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
            $manager->persist($productComponentPrice);

            if ($i > 7) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-triple-ou-plus'));
                $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
                $manager->persist($productComponentPrice);
            } elseif ($i > 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-double'));
                $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
                $manager->persist($productComponentPrice);
            } else {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-camera-arriere-simple'));
                $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
                $manager->persist($productComponentPrice);
            }

            if ($i > 9) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-capteur-empreinte-digitale'));
                $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
                $manager->persist($productComponentPrice);
            }
            if ($i < 5) {
                $productComponentPrice = new TechcareProductComponentPrice();
                $productComponentPrice->setPrice($faker->randomFloat(2, 0, 1000));
                $productComponentPrice->addComponentId($this->getReference('component-prise-jack-audio-micro'));
                $productComponentPrice->addProductId($this->getReference('product-tablette-' . $i));
                $manager->persist($productComponentPrice);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
            ComponentFixtures::class
        ];
    }
}
