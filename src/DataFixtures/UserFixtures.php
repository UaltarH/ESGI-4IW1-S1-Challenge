<?php

namespace App\DataFixtures;

use App\Entity\TechcareUser as User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
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
                ->setLastname('admin')
                ->setFirstname('admin');
            $object->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $object, $pwd
                )
            );
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
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $object->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $object, $pwd
                )
            );
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
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $object->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $object, $pwd
                )
            );
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
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName);
            $object->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $object, $pwd
                )
            );
            $manager->persist($object);
            $this->addReference('user_accountant_' . $i, $object);
        }

        $manager->flush();
    }
}
