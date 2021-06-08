<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonsFixtures extends Fixture implements DependentFixtureInterface
{ 
    const SAISONS = [
        [1, 2008, 'Season 1'],
        [2, 2009, 'Season 2'],
        [3, 2010, 'Season 3'],

];
    public function load(ObjectManager $manager)
    {
        foreach(self::SAISONS as $key => $values) {
            $season = new Season();
            $season->setNumber($values[0]);
            $season->setYear(intval($values[1]));
            $season->setDescription($values[2]);
            $season->setProgram($this->getReference('program_'.rand(1,3)));
            $manager->persist($season);
            $this->addReference('seasons_'.$key, $season);
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



