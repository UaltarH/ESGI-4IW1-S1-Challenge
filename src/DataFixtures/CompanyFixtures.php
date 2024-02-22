<?php

namespace App\DataFixtures;

use App\Entity\TechcareCompany as Company;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $user = $this->getReference('user_owner_' . $i);
            var_dump($user->getFirstName()[0]);
            var_dump($user->getLastName()[0]);
            $company = $faker->company;
            $code = strtoupper(
                utf8_encode($user->getFirstName()[0])
                    . utf8_encode($user->getLastName()[0])
                    . '-'
            );
            if (strlen($company) > 4)
                $code .= strtoupper(substr($company, 0, 4));
            else
                $code .= strtoupper($company);
            $object = (new Company())
                ->setCreatedAt(new DateTimeImmutable())
                ->setCreatedBy("system")
                ->setName($company)
                ->setSiret($faker->numberBetween(00000000000000, 99999999999999))
                ->setPhoneNumber($faker->phoneNumber)
                ->setEmail($faker->email)
                ->setAddress($faker->address)
                ->setOwner($user)
                ->setCode($code);
            $manager->persist($object);
            $this->addReference('company_' . $i, $object);
            $user->setCompany($object);
            $manager->persist($user);
        }

        // set company to other users 
        for ($i = 0; $i < 15; $i++) {
            $company = $this->getReference('company_' . $i);

            $user = $this->getReference('user_employee_' . $i);
            $user->setCompany($company);
            $manager->persist($user);

            $user = $this->getReference('user_accountant_' . $i);
            $user->setCompany($company);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
