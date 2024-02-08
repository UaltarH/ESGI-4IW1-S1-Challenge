<?php

namespace App\DataFixtures;

use App\Entity\TechcareProductCategory as ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $object = (new ProductCategory())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setName("Ordinateur");
        $manager->persist($object);
        $this->addReference("product-category-ordinateur", $object);

        $object = (new ProductCategory())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
            ->setName("Smartphone");
        $manager->persist($object);
        $this->addReference("product-category-smartphone", $object);

        $object = (new ProductCategory())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
            ->setName("Tablette");
        $manager->persist($object);
        $this->addReference("product-category-tablette", $object);

        $manager->flush();
    }
}