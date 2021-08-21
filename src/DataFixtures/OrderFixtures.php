<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        for ($i = 1; $i <= 20; $i++){
            $order = new Order();
            $order->setCreatedAt($faker->dateTimeBetween('-6months', '-3months'));
            $order->setUpdatedAt($faker->dateTimeBetween('-3months', 'now'));
            $order->setPrice($faker->numberBetween(10, 400));
            $order->setUser($users[$faker->numberBetween(0, count($users) -1)]);
            $order->setProduct($products[$faker->numberBetween(0, count($products) -1)]);
            $manager->persist($order);
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
