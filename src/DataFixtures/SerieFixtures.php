<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SerieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $serie = new Serie();
        $serie->setNumber(1);
        $serie->setLevel(1);
        $this->addReference('serie_a_1', $serie);
        $manager->persist($serie);

        $serie2 = new Serie();
        $serie2->setNumber(1);
        $serie2->setLevel(1);
        $this->addReference('serie_a_2', $serie2);
        $manager->persist($serie2);
        $manager->flush();
    }
}
