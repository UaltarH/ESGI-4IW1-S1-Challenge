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

        $object = (new User())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy("system")
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setLastname('admin')
            ->setFirstname('admin')
        ;
        $manager->persist($object);
        $this->addReference('admin', $object);

        // owners of company
        for ($i = 0; $i < 10; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail($faker->email)
                ->setPassword($pwd)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
            ;
            $manager->persist($object);
            $this->addReference('user_' . $i, $object);
        }

        // customers
        for ($i = 0; $i < 50; $i++) {
            $object = (new User())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCreatedBy("system")
                ->setEmail($faker->email)
                ->setPassword($pwd)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
            ;
            $manager->persist($object);
            $this->addReference('user_client_' . $i, $object);
        }

        $manager->flush();
    }
}