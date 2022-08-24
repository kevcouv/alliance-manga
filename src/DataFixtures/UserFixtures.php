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


    /**
     * @throws \Exception
     */

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
                ->setToken($this->generateToken())
                ->setRole(['ROLE_ADMIN'])
            ;
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }



}
