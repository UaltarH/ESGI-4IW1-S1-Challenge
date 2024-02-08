<?php

namespace App\DataFixtures;

use App\Entity\TechcareService as Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Réparation")
            ->setPrice($faker->randomFloat(2, 1, 50));
        $manager->persist($object);
        $this->addReference("service-reparation", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Diagnostic")
            ->setPrice($faker->randomFloat(2, 1, 10));
        $this->addReference("service-diagnostic", $object);
        $manager->persist($object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Achat composants")
            ->setPrice($faker->randomFloat(2, 80, 150));
        $manager->persist($object);
        $this->addReference("service-achat-composants", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Remplacement de pièces")
            ->setPrice($faker->randomFloat(2, 1, 50));
        $manager->persist($object);
        $this->addReference("service-remplacement-de-pieces", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Nettoyage")
            ->setPrice($faker->randomFloat(2, 1, 5));
        $manager->persist($object);
        $this->addReference("service-nettoyage", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Pâte thermique")
            ->setPrice($faker->randomFloat(2, 5, 10));
        $manager->persist($object);
        $this->addReference("service-pate-thermique", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Installation de logiciels")
            ->setPrice($faker->randomFloat(2, 1, 50));
        $manager->persist($object);
        $this->addReference("service-installation-de-logiciels", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Changement de batterie")
            ->setPrice($faker->randomFloat(2, 1, 100));
        $manager->persist($object);
        $this->addReference("service-changement-de-batterie", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Pose de film protecteur")
            ->setPrice($faker->randomFloat(2, 1, 10));
        $manager->persist($object);
        $this->addReference("service-pose-de-film-protecteur", $object);


        $manager->flush();
    }
}