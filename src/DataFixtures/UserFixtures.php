<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++){
            $user = new User();
            $genre = $faker->randomElement($genres);
            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setUserName($user->getFirstName().$user->getLastName())
                ->setEmail($user->getFirstName().$user->getLastName().'@hotmail.com')
                ->setCreatedAt($faker->dateTimeBetween('-5 months', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween('now'))
                ->setIsDisabled($faker->boolean)
                ->setRole(['ROLE_USER'])
            ;
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
