<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonsFixtures extends Fixture
{ 
    const SAISONS = [
        1 => [2008, 'Season 1'],
        2 => [2009, 'Season 2'],
        3 => [2010, 'Season 3'],

];
    public function load(ObjectManager $manager)
    {
        foreach(self::SAISONS as $key => $values) {
            $episodes = new Season();
            $episodes->setNumber($key);
            $episodes->setYear(intval($values[0]));
            $episodes->setDescription($values[1]);
            $episodes->setProgram($this->getReference('program '.rand(1,3)));
            $manager->persist($episodes);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProgramFixtures::class
 
        );
    }

}



