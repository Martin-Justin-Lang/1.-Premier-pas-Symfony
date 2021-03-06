<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ["Game of Thrones","Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.","https://m.media-amazon.com/images/M/MV5BYTRiNDQwYzAtMzVlZS00NTI5LWJjYjUtMzkwNTUzMWMxZTllXkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_SY264_CR8,0,178,264_AL_.jpg"],
        ["The Walking Dead","Sheriff Deputy Rick Grimes wakes up from a coma to learn the world is in ruins and must lead a group of survivors to stay alive.","https://m.media-amazon.com/images/M/MV5BMTc5ZmM0OTQtNDY4MS00ZjMyLTgwYzgtOGY0Y2VlMWFmNDU0XkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_SX178_AL_.jpg"],
        ["Breaking Bad","A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family's future","https://m.media-amazon.com/images/M/MV5BMjhiMzgxZTctNDc1Ni00OTIxLTlhMTYtZTA3ZWFkODRkNmE2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SY264_CR6,0,178,264_AL_.jpg"],
        ["Vikings","Vikings transports us to the brutal and mysterious world of Ragnar Lothbrok, a Viking warrior and farmer who yearns to explore - and raid - the distant shores across the ocean.","https://m.media-amazon.com/images/M/MV5BODk4ZjU0NDUtYjdlOS00OTljLTgwZTUtYjkyZjk1NzExZGIzXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_SX178_AL_.jpg"],
        ["Stranger Things","When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces in order to get him back","https://m.media-amazon.com/images/M/MV5BN2ZmYjg1YmItNWQ4OC00YWM0LWE0ZDktYThjOTZiZjhhN2Q2XkEyXkFqcGdeQXVyNjgxNTQ3Mjk@._V1_SY264_CR0,0,178,264_AL_.jpg"],
    ];

    private $slugify;

    public function __construct(Slugify $slugifyService)
    {
        $this->slugify = $slugifyService;
    }

    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $key => $values) {
        $program = new Program();
        $program->setTitle($values[0]);
        $program->setSummary($values[1]);
        $program->setPoster($values[2]);
        $program->addActor($this->getReference('actor_'.rand(0,4)));
        $program->setCategory($this->getReference('category_'.rand(0,4)));
        $program->setSlug($this->slugify->generate($values[0]));
        $manager->persist($program);
        $this->addReference('program_'.$key, $program);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            ActorFixtures::class
        );
 
    }
}
