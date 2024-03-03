<?php

namespace App\DataFixtures;

use App\Entity\TechcareProduct as Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // iphone
        for ($i = 1; $i < 16; $i++) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('Iphone' . $i)

                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-coque"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-camera-frontale"))
                ->addComponent($i > 12 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 8 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-bouton-volume"))
                ->addComponent($this->getReference("component-compartiment-sim"))
                ->setBrand($this->getReference("brand-apple"));

            if ($i > 10) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_0"));
            }
            if ($i < 10) {
                $object->addComponent($this->getReference("component-bouton-home"));
                $object->setCompany($this->getReference("company_1"));
            }

            $manager->persist($object);
            $this->addReference("product-iphone-" . $i, $object);
        }

        // android
        for ($i = 1; $i < 24; $i++) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('Samsung' . $i)

                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-coque"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-camera-frontale"))
                ->addComponent($i > 12 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 8 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-bouton-volume"))
                ->addComponent($this->getReference("component-compartiment-sim"))
                ->setBrand($this->getReference("brand-samsung"));
            if ($i > 10) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_1"));
            }
            if ($i < 10) {
                $object->addComponent($this->getReference("component-bouton-home"));
                $object->setCompany($this->getReference("company_2"));
            }
            $manager->persist($object);
            $this->addReference("product-samsung-" . $i, $object);
        }
        // android
        for ($i = 1; $i < 10; $i++) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('H' . $i)

                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-coque"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-camera-frontale"))
                ->addComponent($i > 8 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 5 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-bouton-volume"))
                ->addComponent($this->getReference("component-compartiment-sim"))
                ->setBrand($this->getReference("brand-huawei"));
            if ($i > 8) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_2"));
            }
            if ($i < 8) {
                $object->addComponent($this->getReference("component-bouton-home"));
                $object->setCompany($this->getReference("company_3"));
            }

            $manager->persist($object);
            $this->addReference("product-huawei-" . $i, $object);
        }

        // mac
        for ($i = 1; $i < 10; $i++) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('MacBook' . $i)

                ->setProductCategory($this->getReference("product-category-ordinateur"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-boitier"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-pave-tactile"))
                ->addComponent($this->getReference("component-port-usb"))
                ->addComponent($this->getReference("component-port-rj45"))
                ->addComponent($this->getReference("component-port-hdmi-dp-vga"))
                ->addComponent($this->getReference("component-webcam"))
                ->addComponent($this->getReference("component-clavier"))
                ->setBrand($this->getReference("brand-apple"));
            if ($i > 5) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_3"));
            }
            if ($i < 5) {
                $object->addComponent($this->getReference("component-prise-jack-audio-micro"));
                $object->setCompany($this->getReference("company_4"));
            }

            $manager->persist($object);
            $this->addReference("product-macbook-" . $i, $object);
        }

        // pc portable
        for ($i = 100; $i <= 1000; $i += 50) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('Lenovo' . $i)

                ->setProductCategory($this->getReference("product-category-ordinateur"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-boitier"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-bouton-volume"))
                ->addComponent($this->getReference("component-camera-frontale"))
                ->setBrand($this->getReference("brand-lenovo"));
            if ($i > 700) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_4"));
            }
            if ($i < 850) {
                $object->addComponent($this->getReference("component-prise-jack-audio-micro"));
                $object->setCompany($this->getReference("company_5"));
            }

            $manager->persist($object);
            $this->addReference("product-lenovo-" . $i, $object);
        }
        // tablette
        for ($i = 1; $i < 10; $i++) {
            $object = (new Product())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setUpdatedBy("system")
                ->setName('Tablette' . $i)

                ->setProductCategory($this->getReference("product-category-tablette"))
                ->addComponent($this->getReference("component-ecran"))
                ->addComponent($this->getReference("component-coque"))
                ->addComponent($this->getReference("component-batterie"))
                ->addComponent($this->getReference("component-carte-graphique"))
                ->addComponent($this->getReference("component-memoire"))
                ->addComponent($this->getReference("component-processeur"))
                ->addComponent($this->getReference("component-carte-mere"))
                ->addComponent($this->getReference("component-haut-parleurs"))
                ->addComponent($this->getReference("component-camera-frontale"))
                ->addComponent($this->getReference("component-port-de-charge"))
                ->addComponent($this->getReference("component-bouton-power"))
                ->addComponent($this->getReference("component-pave-tactile"))
                ->addComponent($this->getReference("component-port-usb"))
                ->addComponent($this->getReference("component-port-rj45"))
                ->addComponent($this->getReference("component-port-hdmi-dp-vga"))
                ->addComponent($this->getReference("component-webcam"))
                ->addComponent($i > 7 ? $this->getReference("component-camera-arriere-triple-ou-plus") : ($i > 5 ? $this->getReference("component-camera-arriere-double") : $this->getReference("component-camera-arriere-simple")))
                ->setBrand($this->getReference("brand-apple"));
            if ($i > 9) {
                $object->addComponent($this->getReference("component-capteur-empreinte-digitale"));
                $object->setCompany($this->getReference("company_5"));
            }
            if ($i < 5) {
                $object->addComponent($this->getReference("component-prise-jack-audio-micro"));
                $object->setCompany($this->getReference("company_6"));
            }

            $manager->persist($object);
            $this->addReference("product-tablette-" . $i, $object);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProductCategoryFixtures::class,
            ComponentFixtures::class,
            BrandFixtures::class,
        ];
    }
}
