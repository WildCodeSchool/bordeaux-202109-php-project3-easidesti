<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class LetterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $letter = new Letter();
        $letter->setWord($this->getReference('word_haricot'));
        $letter->setContent('a');
        $letter->setCreatedAt(new DateTime());
        $manager->persist($letter);

        $letter2 = new Letter();
        $letter2->setWord($this->getReference('word_banc'));
        $letter2->setContent('a');
        $letter2->setCreatedAt(new DateTime());
        $manager->persist($letter2);

        $letter3 = new Letter();
        $letter3->setWord($this->getReference('word_pain'));
        $letter3->setContent('a');
        $letter3->setCreatedAt(new DateTime());
        $manager->persist($letter3);

        $letter4 = new Letter();
        $letter4->setWord($this->getReference('word_jambe'));
        $letter4->setContent('a');
        $letter4->setCreatedAt(new DateTime());
        $manager->persist($letter4);

        $letter5 = new Letter();
        $letter5->setWord($this->getReference('word_ail'));
        $letter5->setContent('a');
        $letter5->setCreatedAt(new DateTime());
        $manager->persist($letter5);

        $letter6 = new Letter();
        $letter6->setWord($this->getReference('word_cadeau'));
        $letter6->setContent('a');
        $letter6->setCreatedAt(new DateTime());
        $manager->persist($letter6);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
