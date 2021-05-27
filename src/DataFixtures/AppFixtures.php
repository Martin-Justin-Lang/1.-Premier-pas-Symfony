<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach(self::CATEGORIES as $key => $categoryName) {
        $category = new Category();
        $category->setName('Horreur');

        $manager->persist($category);
    }
        for ($i = 1; $i <= 50; $i++) {  
            $category = new Category();  
            $category->setName('Nom de catégorie ' . $i);  
            $manager->persist($category);  
        }
        $manager->flush();
    }
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
    ];
}



