<?php

namespace App\DataFixtures;

use App\Entity\Personnage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonnageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 10; $i++){
            $characters = new Personnage();
            $characters->setName($faker->words($faker->numberBetween(1, 3), true));
            $characters->setDescription($faker->paragraphs($faker->numberBetween(2, 4), true));
            $manager->persist($characters);
        }
        $manager->flush();
    }
}
