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
        $letter->setContent('a');
        $letter->setNbProposal(6);
        $letter->addWord($this->getReference('word_banc'));
        $letter->addWord($this->getReference('word_haricot'));
        $letter->addWord($this->getReference('word_banc'));
        $letter->addWord($this->getReference('word_pain'));
        $letter->addWord($this->getReference('word_jambe'));
        $letter->addWord($this->getReference('word_ail'));
        $letter->addWord($this->getReference('word_cadeau'));
        $this->addReference('letter_a', $letter);
        $manager->persist($letter);

        $letter2 = new Letter();
        $letter2->setContent('e');
        $letter2->setNbProposal(8);
        $this->addReference('letter_e', $letter2);
        $manager->persist($letter2);

        $letter3 = new Letter();
        $letter3->setContent('s');
        $letter3->setNbProposal(4);
        $this->addReference('letter_s', $letter3);
        $manager->persist($letter3);

        $letter4 = new Letter();
        $letter4->setContent('i');
        $letter4->setNbProposal(6);
        $this->addReference('letter_i', $letter4);
        $manager->persist($letter4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
