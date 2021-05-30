<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setTitle('yavuz');
        $program->setSummary('yavuz');
        $program->setPoster('yavuz');
        //$program->category($this->getReference('seasons'.rand(1,10), $program));
        $manager->flush();

        $this->addReference('program_'.rand(1,10), $program);
    }

    public function getDependencies()
    {
        return array(
            SeasonsFixtures::class,
            CategoryFixtures::class
 
        );
 
    }
}
