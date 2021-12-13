<?php

namespace App\DataFixtures;

use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class WordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $word = new Word();
        $word->setContent('haricot');
        $word->getDefinition('Légume vert');
        $word->setCreatedAt(DateTime);
        $this->addReference('word_haricot');
        $manager->persist($word);

        $word2 = new Word();
        $word2->setContent('banc');
        $word2->getDefinition('on s\'assoie dessus');
        $word2->setCreatedAt(DateTime);
        $this->addReference('word_banc');
        $manager->persist($word2);

        $word3 = new Word();
        $word3->setContent('pain');
        $word3->getDefinition('Il est fabriqué chez le boulanger');
        $word3->setCreatedAt(DateTime);
        $this->addReference('word_pain');
        $manager->persist($word3);

        $word4 = new Word();
        $word4->setContent('jambe');
        $word4->getDefinition('Partie du corps humain');
        $word4->setCreatedAt(DateTime);
        $this->addReference('word_jambe');
        $manager->persist($word4);

        $word5 = new Word();
        $word5->setContent('épouventail');
        $word5->getDefinition('Est placé dans les champs pour faire fuire les oiseaux');
        $word5->setCreatedAt(DateTime);
        $this->addReference('word_epouventail');
        $manager->persist($word5);

        $word6 = new Word();
        $word6->setContent('cadeau');
        $word6->getDefinition('S\'offre à noël');
        $word6->setCreatedAt(DateTime);
        $this->addReference('word_cadeau');
        $manager->persist($word6);

        $manager->flush();
    }
}
