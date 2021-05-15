<?php

namespace App\DataFixtures;

use App\Entity\Category;
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
        $categories = $manager->getRepository(Category::class)->findAll();


        for ($i = 1; $i <= 57; $i++){
            $product = new Product();
            $product->setTitle($faker->words($faker->numberBetween(2, 3),true))
                ->setNameCharacter($faker->words($faker->numberBetween(1, 3),true))
                ->setImage('0'.$i.'.png')
                ->setSmallDescription($faker->paragraph(3, true))
                ->setFullDescription($faker->paragraphs($faker->numberBetween(2,4), true))
                ->setPrice($faker->numberBetween(10, 120))
                ->setMaterial($faker->word())
                ->setCreatedAt($faker->dateTimeThisYear('now'))
                ->setUpdatedAt($faker->dateTimeBetween('now'))
                ->setIsPublished(1)
                ->setManga($licences[$faker->numberBetween(0, count($licences) -1)])
                ->setCategory($categories[$faker->numberBetween(0, count($categories) -1)]);
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MangaFixtures::class,
            CategoryFixtures::class
        ];
    }

}
