<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
Use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 1; $i <= 10; $i++){
            $addresses = new Address();
            $addresses->setAddress($faker->address);
            $addresses->setSubAddress($faker->secondaryAddress);
            $addresses->setPostalCode($faker->postcode);
            $addresses->setCountry($faker->country);
            $addresses->setSociety($faker->domainName);
            $addresses->setVat($faker->vat);
            $addresses->setPhoneNumber($faker->phoneNumber);
            $addresses->setUser($users[$faker->numberBetween(0, count($users) -1)]);
            $manager->persist($addresses);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
