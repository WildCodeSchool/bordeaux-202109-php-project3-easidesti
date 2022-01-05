<?php

namespace App\DataFixtures;

use App\Entity\Pronunciation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PronunciationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pronunciation = new Pronunciation();
        $pronunciation->setName('table');
        $pronunciation->setPicture('lettre_a_6.png');
        $this->addReference('pronunciation_table', $pronunciation);
        $manager->persist($pronunciation);

        $pronunciation2 = new Pronunciation();
        $pronunciation2->setName('rail');
        $pronunciation2->setPicture('lettre_a_5.png');
        $this->addReference('pronunciation_rail', $pronunciation2);
        $manager->persist($pronunciation2);

        $pronunciation3 = new Pronunciation();
        $pronunciation3->setName('maison');
        $pronunciation3->setPicture('lettre_a_4.png');
        $this->addReference('pronunciation_maison', $pronunciation3);
        $manager->persist($pronunciation3);

        $pronunciation4 = new Pronunciation();
        $pronunciation4->setName('pain');
        $pronunciation4->setPicture('lettre_a_3.png');
        $this->addReference('pronunciation_pain', $pronunciation4);
        $manager->persist($pronunciation4);

        $pronunciation5 = new Pronunciation();
        $pronunciation5->setName('chaussure');
        $pronunciation5->setPicture('lettre_a_2.png');
        $this->addReference('pronunciation_chaussure', $pronunciation5);
        $manager->persist($pronunciation5);

        $pronunciation6 = new Pronunciation();
        $pronunciation6->setName('ambulance');
        $pronunciation6->setPicture('lettre_a_1.png');
        $this->addReference('pronunciation_ambulance', $pronunciation6);
        $manager->persist($pronunciation6);

        $manager->flush();
    }
}
