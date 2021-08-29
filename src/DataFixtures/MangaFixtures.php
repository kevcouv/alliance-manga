<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MangaFixtures extends Fixture
{
    private $licences = ['Attack On Titan', 'Berserk', 'Bleach', 'City Hunter', 'Demon Slayer', 'Dragon Ball Z', 'Fate Series', 'Full Metal Alchemist','My Hero Academia', 'One Piece', 'The Rising of the Shield Hero'];


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        foreach ($this->licences as $licence){
            $anime = new Manga();
            $anime->setTitle($licence);
            $anime->setSlug($slugify->slugify($anime->getTitle()));
            $anime->setDescription($faker->text(300));
            $anime->setImage($licence.'.png');
            $anime->setLogo($licence.'.png');
            $manager->persist($anime);
        }
        $manager->flush();
    }
}
