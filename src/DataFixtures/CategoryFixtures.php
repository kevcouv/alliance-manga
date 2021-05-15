<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    private $categories = ['Figurine', 'Mug', 'Peluche'];

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $cat){
            $category = new Category();
            $category->setTitle($cat);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
