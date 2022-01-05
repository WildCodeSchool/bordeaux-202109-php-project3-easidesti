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
        for ($i = 0; $i < 29; $i++) {
            $letter->addWord($this->getReference('letter_a_serie_1_word_' . $i));
        }
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
