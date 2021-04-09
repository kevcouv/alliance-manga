<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CharacterFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++){
            $pnj = new Character();
            $pnj->setName($faker->words($faker->numberBetween(2, 4), true))
                ->setDescription($faker->text(250));
            $manager->persist($pnj);
        }

        $manager->flush();
    }
}
