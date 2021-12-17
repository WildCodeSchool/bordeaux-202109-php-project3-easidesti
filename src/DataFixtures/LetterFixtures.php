<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class LetterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $letter = new Letter();
        $letter->setContent('a');
        $this->addReference('letter_a', $letter);
        $manager->persist($letter);

        $letter2 = new Letter();
        $letter2->setContent('e');
        $this->addReference('letter_e', $letter2);
        $manager->persist($letter2);

        $letter3 = new Letter();
        $letter3->setContent('s');
        $this->addReference('letter_s', $letter3);
        $manager->persist($letter3);

        $letter4 = new Letter();
        $letter4->setContent('i');
        $this->addReference('letter_i', $letter4);
        $manager->persist($letter4);

        $manager->flush();
    }
}
