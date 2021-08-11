<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {


        $faker = Factory::create('fr_FR');
        $products= $manager->getRepository(Product::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 1; $i <= 40; $i++){
            $comments = new Comment();
            $comments->setMessage($faker->text);
            $comments->setRating($faker->numberBetween(1, 5));
            $comments->setCreatedAt($faker->dateTimeBetween('-6 months', 'now'));
            $comments->setProduct($products[$faker->numberBetween(0, count($products) -1)]);
            $comments->setUser($users[$faker->numberBetween(0, count($users) -1)]);
            $comments->setisPublished(1);
            $manager->persist($comments);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
            UserFixtures::class
        ];
    }
}
