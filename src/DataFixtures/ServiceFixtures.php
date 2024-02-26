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
            ->setName("Réparation");
        $manager->persist($object);
        $this->addReference("service-reparation", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Diagnostic");
        $this->addReference("service-diagnostic", $object);
        $manager->persist($object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Achat composants");
        $manager->persist($object);
        $this->addReference("service-achat-composants", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Remplacement de pièces");
        $manager->persist($object);
        $this->addReference("service-remplacement-de-pieces", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Nettoyage");
        $manager->persist($object);
        $this->addReference("service-nettoyage", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Pâte thermique");
        $manager->persist($object);
        $this->addReference("service-pate-thermique", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Installation de logiciels");
        $manager->persist($object);
        $this->addReference("service-installation-de-logiciels", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Changement de batterie");
        $manager->persist($object);
        $this->addReference("service-changement-de-batterie", $object);

        $object = (new Service())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Pose de film protecteur");
        $manager->persist($object);
        $this->addReference("service-pose-de-film-protecteur", $object);


        $manager->flush();
    }
}
