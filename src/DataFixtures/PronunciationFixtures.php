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
        $pronunciation->setGrapheme('[a]');
        $this->addReference('pronunciation_table', $pronunciation);
        $manager->persist($pronunciation);

        $pronunciation2 = new Pronunciation();
        $pronunciation2->setName('rail');
        $pronunciation2->setPicture('lettre_a_5.png');
        $pronunciation2->setGrapheme('[ail]');
        $this->addReference('pronunciation_rail', $pronunciation2);
        $manager->persist($pronunciation2);

        $pronunciation3 = new Pronunciation();
        $pronunciation3->setName('maison');
        $pronunciation3->setPicture('lettre_a_4.png');
        $pronunciation3->setGrapheme('[è]');
        $this->addReference('pronunciation_maison', $pronunciation3);
        $manager->persist($pronunciation3);

        $pronunciation4 = new Pronunciation();
        $pronunciation4->setName('pain');
        $pronunciation4->setPicture('lettre_a_3.png');
        $pronunciation4->setGrapheme('[in]');
        $this->addReference('pronunciation_pain', $pronunciation4);
        $manager->persist($pronunciation4);

        $pronunciation5 = new Pronunciation();
        $pronunciation5->setName('chaussure');
        $pronunciation5->setPicture('lettre_a_2.png');
        $pronunciation5->setGrapheme('[o]');
        $this->addReference('pronunciation_chaussure', $pronunciation5);
        $manager->persist($pronunciation5);

        $pronunciation6 = new Pronunciation();
        $pronunciation6->setName('ambulance');
        $pronunciation6->setPicture('lettre_a_1.png');
        $pronunciation6->setGrapheme('[an]');
        $this->addReference('pronunciation_ambulance', $pronunciation6);
        $manager->persist($pronunciation6);

        $pronunciation7 = new Pronunciation();
        $pronunciation7->setName('cerise');
        $pronunciation7->setPicture('lettre_e_1.png');
        $this->addReference('pronunciation_cerise', $pronunciation7);
        $manager->persist($pronunciation7);

        $pronunciation8 = new Pronunciation();
        $pronunciation8->setName('échelle');
        $pronunciation8->setPicture('lettre_e_2.png');
        $this->addReference('pronunciation_échelle', $pronunciation8);
        $manager->persist($pronunciation8);

        $pronunciation9 = new Pronunciation();
        $pronunciation9->setName('eau');
        $pronunciation9->setPicture('lettre_e_3.png');
        $this->addReference('pronunciation_eau', $pronunciation9);
        $manager->persist($pronunciation9);

        $pronunciation10 = new Pronunciation();
        $pronunciation10->setName('ceinture');
        $pronunciation10->setPicture('lettre_e_4.png');
        $this->addReference('pronunciation_ceinture', $pronunciation10);
        $manager->persist($pronunciation10);

        $pronunciation11 = new Pronunciation();
        $pronunciation11->setName('entonnoir');
        $pronunciation11->setPicture('lettre_e_5.png');
        $this->addReference('pronunciation_entonnoir', $pronunciation11);
        $manager->persist($pronunciation11);

        $pronunciation12 = new Pronunciation();
        $pronunciation12->setName('poêle');
        $pronunciation12->setPicture('lettre_e_6.png');
        $this->addReference('pronunciation_poêle', $pronunciation12);
        $manager->persist($pronunciation12);

        $pronunciation13 = new Pronunciation();
        $pronunciation13->setName('abeille');
        $pronunciation13->setPicture('lettre_e_7.png');
        $this->addReference('pronunciation_abeille', $pronunciation13);
        $manager->persist($pronunciation13);

        $pronunciation14 = new Pronunciation();
        $pronunciation14->setName('feu');
        $pronunciation14->setPicture('lettre_e_8.png');
        $this->addReference('pronunciation_feu', $pronunciation14);
        $manager->persist($pronunciation14);

        $pronunciation15 = new Pronunciation();
        $pronunciation15->setName('île');
        $pronunciation15->setPicture('lettre_i_1.png');
        $this->addReference('pronunciation_île', $pronunciation15);
        $manager->persist($pronunciation15);

        $pronunciation16 = new Pronunciation();
        $pronunciation16->setName('écureuil');
        $pronunciation16->setPicture('lettre_i_2.png');
        $this->addReference('pronunciation_écureuil', $pronunciation16);
        $manager->persist($pronunciation16);

        $pronunciation17 = new Pronunciation();
        $pronunciation17->setName('pain');
        $pronunciation17->setPicture('lettre_i_3.png');
        $this->addReference('pronunciation_pain_i', $pronunciation17);
        $manager->persist($pronunciation17);

        $pronunciation18 = new Pronunciation();
        $pronunciation18->setName('oiseau');
        $pronunciation18->setPicture('lettre_i_4.png');
        $this->addReference('pronunciation_oiseau', $pronunciation18);
        $manager->persist($pronunciation18);

        $pronunciation19 = new Pronunciation();
        $pronunciation19->setName('poing');
        $pronunciation19->setPicture('lettre_i_5.png');
        $this->addReference('pronunciation_poing', $pronunciation19);
        $manager->persist($pronunciation19);

        $pronunciation20 = new Pronunciation();
        $pronunciation20->setName('serpent');
        $pronunciation20->setPicture('lettre_s_1.png');
        $this->addReference('pronunciation_serpent', $pronunciation20);
        $manager->persist($pronunciation20);

        $pronunciation21 = new Pronunciation();
        $pronunciation21->setName('poison');
        $pronunciation21->setPicture('lettre_s_2.png');
        $this->addReference('pronunciation_poison', $pronunciation21);
        $manager->persist($pronunciation21);

        $pronunciation22 = new Pronunciation();
        $pronunciation22->setName('chat');
        $pronunciation22->setPicture('lettre_s_3.png');
        $this->addReference('pronunciation_chat', $pronunciation22);
        $manager->persist($pronunciation22);

        $pronunciation24 = new Pronunciation();
        $pronunciation24->setName('muet');
        $pronunciation24->setPicture('lettre_s_4.png');
        $this->addReference('pronunciation_muet', $pronunciation24);
        $manager->persist($pronunciation24);

        $manager->flush();
    }
}
