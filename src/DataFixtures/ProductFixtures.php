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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->setBrand($this->getReference("brand-apple"));
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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->setBrand($this->getReference("brand-samsung"));
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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-smartphone"))
                ->setBrand($this->getReference("brand-huawei"));

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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-ordinateur"))
                ->setBrand($this->getReference("brand-apple"));

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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-ordinateur"))
                ->setBrand($this->getReference("brand-lenovo"));

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
                ->setReleaseYear($faker->year)
                ->setProductCategory($this->getReference("product-category-tablette"))
                ->setBrand($this->getReference("brand-apple"));

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
