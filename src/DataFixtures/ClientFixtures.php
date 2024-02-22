<?php

namespace App\DataFixtures;

use App\Entity\TechcareClient as Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $object = (new Client())
                    ->setFirstname($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setEmail($faker->email)
                    ->setBillingAddress($faker->address)
                    ->setPhoneNumber($faker->phoneNumber)
                    ->setCreatedBy("system")
                    ->setUpdatedBy("system")
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                    ->setCompany($this->getReference('company_' . $j));

                $manager->persist($object);
                $this->addReference('client_' . $i * 5 + $j, $object);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CompanyFixtures::class,
        ];
    }
}
