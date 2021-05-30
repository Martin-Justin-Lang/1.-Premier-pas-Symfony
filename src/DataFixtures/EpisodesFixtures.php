<?php

namespace App\DataFixtures;

use App\Entity\Episodes;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodesFixtures extends Fixture
{ 
    const EPISODES = [
    'Seven Thirty-Seven',
    'Grilled',
    'Bit by a Dead Bee',
    'Down',
    'Breakage',
    'Peekaboo',
    'Negro y Azul',
    'Better Call Saul',
    '4 Days Out',
    'Over',
    'Mandala',
    'Phoenix',
    'ABQ'

];

    public function load(ObjectManager $manager)
    {
        foreach(self::EPISODES as $key => $episodesName) {
        $episodes = new Episodes();
        $episodes->setName($episodesName);
        $manager->persist($episodes);
        }
        
        $manager->flush();
    }
}



