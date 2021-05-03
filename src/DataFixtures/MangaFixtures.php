<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MangaFixtures extends Fixture
{
    private $licences = ['Attack On Titan', 'Berserk', 'Bleach', 'City Hunter', 'Demon Slayer', 'Dragon Ball Z', 'Fate Series', 'Full Metal Alchemist','My Hero Academia', 'The Rising of the Shield Hero'];


    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        foreach ($this->licences as $licence){
            $anime = new Manga();
            $anime->setTitle($licence);
            $anime->setDescription($faker->text(300));
            $anime->setImage($licence.'.png');
            $manager->persist($anime);
        }
        $manager->flush();
    }
}
