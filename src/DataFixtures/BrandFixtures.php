<?php

namespace App\DataFixtures;

use App\Entity\TechcareBrand as Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $object = (new Brand())
            ->setName("Apple")
            ->setCreatedBy("system")
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($object);
        $this->addReference("brand-apple", $object);

        $object = (new Brand())
            ->setName("Samsung")
            ->setCreatedBy("system")
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($object);
        $this->addReference("brand-samsung", $object);

        $object = (new Brand())
            ->setName("Huawei")
            ->setCreatedBy("system")
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($object);
        $this->addReference("brand-huawei", $object);

        $object = (new Brand())
            ->setName("Lenovo")
            ->setCreatedBy("system")
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($object);
        $this->addReference("brand-lenovo", $object);

        $manager->flush();
    }
}