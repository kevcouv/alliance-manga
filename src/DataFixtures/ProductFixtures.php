<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $licences = $manager->getRepository(Manga::class)->findAll();

        for ($i = 1; $i <= 20; $i++){
            $product = new Product();
            $product->setTitle($faker->words($faker->numberBetween(2, 4),true))
                ->setNameCharacter($faker->words($faker->numberBetween(1, 4),true))
                ->setImage('0'.$i.'.png')
                ->setSmallDescription($faker->paragraph(3, true))
                ->setFullDescription($faker->paragraphs($faker->numberBetween(2,4), true))
                ->setPrice($faker->numberBetween(10, 120))
                ->setSize($faker->numberBetween(5, 50))
                ->setMaterial($faker->word())
                ->setCreatedAt($faker->dateTimeThisYear('now'))
                ->setIsPublished(1)
                ->setManga($licences[$faker->numberBetween(0, count($licences) -1)]);
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MangaFixtures::class,
        ];
    }

}
