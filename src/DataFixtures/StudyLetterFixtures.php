<?php

namespace App\DataFixtures;

use App\Entity\StudyLetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudyLetterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $studyLetter = new StudyLetter();
            $studyLetter->setPosition($i);
            $studyLetter->setAudio('a_' . $i);
            $manager->persist($studyLetter);
        }

        for ($i = 1; $i <= 4; $i++) {
            $studyLetter = new StudyLetter();
            $studyLetter->setPosition($i);
            $studyLetter->setAudio('e_' . $i);
            $manager->persist($studyLetter);
        }
        for ($i = 1; $i <= 4; $i++) {
            $studyLetter = new StudyLetter();
            $studyLetter->setPosition($i);
            $studyLetter->setAudio('s_' . $i);
            $manager->persist($studyLetter);
        }
        for ($i = 1; $i <= 4; $i++) {
            $studyLetter = new StudyLetter();
            $studyLetter->setPosition($i);
            $studyLetter->setAudio('i_' . $i);
            $manager->persist($studyLetter);
        }

        $manager->flush();
    }
}
