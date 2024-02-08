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

        $pwd = 'test';
        for ($i = 0; $i < 10; $i++) {
            for($j = 0; $j < 5; $j++) {
                $object = (new Client())
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setCreatedBy("system")
                    ->setEmail($faker->email)
                    ->setRoles(['ROLE_CLIENT'])
                    ->setPassword($pwd)
                    ->setLastname($faker->lastName)
                    ->setFirstname($faker->firstName)
                    ->setPhoneNumber($faker->phoneNumber)
                    ->setBillingAddress($faker->address)
                    ->setCompany($this->getReference('company_' . $j))
                    ->setUser($this->getReference('user_client_' . $i*5 + $j));
                $manager->persist($object);
                $this->addReference('client_' . $i*5 + $j, $object);
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