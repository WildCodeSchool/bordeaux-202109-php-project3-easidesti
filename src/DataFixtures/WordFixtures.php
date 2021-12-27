<?php

namespace App\DataFixtures;

use App\Entity\Word;
use App\Service\Definition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class WordFixtures extends Fixture
{
    private $definition;

    public function __construct(Definition $definition)
    {
        $this->definition = $definition;
    }

    public function load(ObjectManager $manager): void
    {
        $word = new Word();
        $word->setContent('haricot');
        $word->setDefinition($this->definition->generateDefinition($word->getContent()));
        $word->setCreatedAt(new DateTime());
        $this->addReference('word_haricot', $word);
        $manager->persist($word);

        $word2 = new Word();
        $word2->setContent('banc');
        $word2->setDefinition($this->definition->generateDefinition($word2->getContent()));
        $word2->setCreatedAt(new DateTime());
        $this->addReference('word_banc', $word2);
        $manager->persist($word2);

        $word3 = new Word();
        $word3->setContent('pain');
        $word3->setDefinition($this->definition->generateDefinition($word3->getContent()));
        $word3->setCreatedAt(new DateTime());
        $this->addReference('word_pain', $word3);
        $manager->persist($word3);

        $word4 = new Word();
        $word4->setContent('jambe');
        $word4->setDefinition($this->definition->generateDefinition($word4->getContent()));
        $word4->setCreatedAt(new DateTime());
        $this->addReference('word_jambe', $word4);
        $manager->persist($word4);

        $word5 = new Word();
        $word5->setContent('ail');
        $word5->setDefinition($this->definition->generateDefinition($word5->getContent()));
        $word5->setCreatedAt(new DateTime());
        $this->addReference('word_ail', $word5);
        $manager->persist($word5);

        $word6 = new Word();
        $word6->setContent('cadeau');
        $word6->setDefinition($this->definition->generateDefinition($word6->getContent()));
        $word6->setCreatedAt(new DateTime());
        $this->addReference('word_cadeau', $word6);
        $manager->persist($word6);

        $word7 = new Word();
        $word7->setContent('papa');
        $word7->setDefinition($this->definition->generateDefinition($word7->getContent()));
        $word7->setCreatedAt(new DateTime());
        $this->addReference('word_papa', $word7);
        $manager->persist($word7);

        $manager->flush();
    }
}
