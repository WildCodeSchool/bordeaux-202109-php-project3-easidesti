<?php

namespace App\DataFixtures;

use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class WordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $word = new Word();
        $word->setContent('haricot');
        $word->setDefinition('Légume vert');
        $word->setCreatedAt(new DateTime());
        $this->addReference('word_haricot', $word);
        $manager->persist($word);

        $word2 = new Word();
        $word2->setContent('banc');
        $word2->setDefinition('on s\'assoie dessus');
        $word2->setCreatedAt(new DateTime());
        $this->addReference('word_banc', $word2);
        $manager->persist($word2);

        $word3 = new Word();
        $word3->setContent('pain');
        $word3->setDefinition('Il est fabriqué chez le boulanger');
        $word3->setCreatedAt(new DateTime());
        $this->addReference('word_pain', $word3);
        $manager->persist($word3);

        $word4 = new Word();
        $word4->setContent('jambe');
        $word4->setDefinition('Partie du corps humain');
        $word4->setCreatedAt(new DateTime());
        $this->addReference('word_jambe', $word4);
        $manager->persist($word4);

        $word5 = new Word();
        $word5->setContent('ail');
        $word5->setDefinition('Est proche de l\'échalotte');
        $word5->setCreatedAt(new DateTime());
        $this->addReference('word_ail', $word5);
        $manager->persist($word5);

        $word6 = new Word();
        $word6->setContent('cadeau');
        $word6->setDefinition('S\'offre à noël');
        $word6->setCreatedAt(new DateTime());
        $this->addReference('word_cadeau', $word6);
        $manager->persist($word6);


        $manager->flush();
    }
}
