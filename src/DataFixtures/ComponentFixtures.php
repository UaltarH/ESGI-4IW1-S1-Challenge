<?php

namespace App\DataFixtures;

use App\Entity\TechcareComponent as Component;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ComponentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // TODO : supprimer
        $faker = Factory::create('fr_FR');

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Carte mère");
        $manager->persist($object);
        $this->addReference("component-carte-mere", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Processeur");

        $manager->persist($object);
        $this->addReference("component-processeur", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Mémoire");

        $manager->persist($object);
        $this->addReference("component-memoire", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Carte graphique");

        $manager->persist($object);
        $this->addReference("component-carte-graphique", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Alimentation");

        $manager->persist($object);
        $this->addReference("component-alimentation", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Boitier");

        $manager->persist($object);
        $this->addReference("component-boitier", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Écran");

        $manager->persist($object);
        $this->addReference("component-ecran", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Clavier");

        $manager->persist($object);
        $this->addReference("component-clavier", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Pavé tactile");

        $manager->persist($object);
        $this->addReference("component-pave-tactile", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Haut-parleurs");

        $manager->persist($object);
        $this->addReference("component-haut-parleurs", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Bouton home");

        $manager->persist($object);
        $this->addReference("component-bouton-home", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Bouton power");

        $manager->persist($object);
        $this->addReference("component-bouton-power", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Bouton volume");

        $manager->persist($object);
        $this->addReference("component-bouton-volume", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Compartiment sim");

        $manager->persist($object);
        $this->addReference("component-compartiment-sim", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Batterie");

        $manager->persist($object);
        $this->addReference("component-batterie", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Webcam");

        $manager->persist($object);
        $this->addReference("component-webcam", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Caméra arrière simple");

        $manager->persist($object);
        $this->addReference("component-camera-arriere-simple", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Caméra arrière double");

        $manager->persist($object);
        $this->addReference("component-camera-arriere-double", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Caméra arrière triple ou plus");

        $manager->persist($object);
        $this->addReference("component-camera-arriere-triple-ou-plus", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Caméra frontale");

        $manager->persist($object);
        $this->addReference("component-camera-frontale", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Coque");

        $manager->persist($object);
        $this->addReference("component-coque", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Port de charge");

        $manager->persist($object);
        $this->addReference("component-port-de-charge", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Port USB");

        $manager->persist($object);
        $this->addReference("component-port-usb", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Port RJ45");

        $manager->persist($object);
        $this->addReference("component-port-rj45", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Port HDMI/DP/VGA");

        $manager->persist($object);
        $this->addReference("component-port-hdmi-dp-vga", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Prise jack audio/micro");

        $manager->persist($object);
        $this->addReference("component-prise-jack-audio-micro", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Capteur empreinte digitale");

        $manager->persist($object);
        $this->addReference("component-capteur-empreinte-digitale", $object);

        $object = (new Component())
            ->setCreatedBy("system")
            ->setCreatedAt(new DateTimeImmutable())
            ->setName("Autres");

        $manager->persist($object);
        $this->addReference("component-autres", $object);

        $manager->flush();
    }
}
