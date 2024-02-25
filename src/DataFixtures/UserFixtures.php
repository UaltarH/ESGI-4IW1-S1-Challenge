<?php

namespace App\DataFixtures;

use App\Entity\TechcareUser as User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $pwd = 'test';

        // admin
        for ($i = 0; $i < 2; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail('admin' . $i . '@user.fr')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($pwd)
                ->setLastname('admin')
                ->setFirstname('admin');
            $manager->persist($object);
            $this->addReference('admin_' . $i, $object);
        }

        // owners of company
        for ($i = 0; $i < 15; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail($faker->email)
                ->setRoles(['ROLE_OWNER_COMPANY'])
                ->setPassword($pwd)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $manager->persist($object);
            $this->addReference('user_owner_' . $i, $object);
        }

        // employees
        for ($i = 0; $i < 15; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail($faker->email)
                ->setRoles(['ROLE_COMPANY'])
                ->setPassword($pwd)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $manager->persist($object);
            $this->addReference('user_employee_' . $i, $object);
        }

        // accountants
        for ($i = 0; $i < 15; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail($faker->email)
                ->setRoles(['ROLE_ACCOUNTANT'])
                ->setPassword($pwd)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $manager->persist($object);
            $this->addReference('user_accountant_' . $i, $object);
        }

        $manager->flush();
    }
}
