<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class EpisodesFixtures extends Fixture implements DependentFixtureInterface
{ 
    const EPISODES = [
    ['Seven Thirty-Seven',1, 'test'],
    ['Grilled', 2, 'test'],
    ['Bit by a Dead Bee',3, 'test'],
    ['Down', 4, 'test'],
];

private $slugify;

public function __construct(Slugify $slugifyService)
{
    $this->slugify = $slugifyService;
}

    public function load(ObjectManager $manager)
    {
        foreach(self::EPISODES as $key => $values) {
            $episodes = new Episode();
            $episodes->setTitle($values[0]);
            $episodes->setNumber($values[1]);
            $episodes->setSynopsis($values[2]);
            $episodes->setSeason($this->getReference('seasons_'.rand(0,2)));
            $episodes->setSlug($this->slugify->generate($values[0]));
            $manager->persist($episodes);
            $this->addReference('episode_'.$key, $episodes);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SeasonsFixtures::class
        );
    }

}



