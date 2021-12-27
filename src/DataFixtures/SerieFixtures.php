<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SerieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $serie = new Serie();
        $serie->addWord($this->getReference('word_haricot'));
        $serie->addWord($this->getReference('word_pain'));
        $serie->addWord($this->getReference('word_banc'));
        $serie->addWord($this->getReference('word_papa'));
        $serie->addWord($this->getReference('word_jambe'));
        $serie->addWord($this->getReference('word_ail'));
        $serie->addWord($this->getReference('word_cadeau'));
        $manager->persist($serie);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
