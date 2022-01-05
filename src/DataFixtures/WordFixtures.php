<?php

namespace App\DataFixtures;

use App\Entity\Word;
use App\Service\Definition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class WordFixtures extends Fixture implements DependentFixtureInterface
{
    private $definition;

    public function __construct(Definition $definition)
    {
        $this->definition = $definition;
    }

    public function load(ObjectManager $manager): void
    {
        $wordsSerie1A = [
            'maison',
            'papa',
            'papa',
            'maman',
            'table',
            'jardin',
            'mal',
            'carte',
            'nature',
            'vache',
            'achat',
            'achat',
            'barbe',
            'classe',
            'matin',
            'branche',
            'chat',
            'facteur',
            'lapin',
            'mars',
            'plante',
            'animal',
            'animal',
            'arbre',
            'arme',
            'aube',
            'autour',
            'avenir',
            'brave',
        ];

        $pronunciationSerie1A = [
            $this->getReference('pronunciation_maison'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_ambulance'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_ambulance'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_chaussure'),
            $this->getReference('pronunciation_chaussure'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
        ];

        foreach ($wordsSerie1A as $key => $wordSerie) {
            $word = new Word();
            $word->setContent($wordsSerie1A[$key]);
            $word->setDefinition($this->definition->generateDefinition($word->getContent()));
            $this->addReference('letter_a_serie_1_word_' . $key, $word);
            $word->setSerie($this->getReference('serie_a_1'));
            $word->setPronunciation($pronunciationSerie1A[$key]);
            $manager->persist($word);
        }

        $pronunciationSerie2A = [ //31
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_ambulance'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_ambulance'),
            $this->getReference('pronunciation_ambulance'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_chaussure'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
            $this->getReference('pronunciation_table'),
        ];
        $wordsSerie2A = [ //31
            'cheval',
            'enfant',
            'image',
            'mardi',
            'moustache',
            'sage',
            'année',
            'article',
            'aviateur',
            'aviateur',
            'café',
            'cage',
            'carton',
            'cave',
            'chaleur',
            'chambre',
            'chanteur',
            'charme',
            'famille',
            'journal',
            'maladie',
            'maladie',
            'marbre',
            'marche',
            'marque',
            'pauvre',
            'rédaction',
            'sable',
            'salade',
            'salade',
        ];

        foreach ($wordsSerie2A as $key => $wordSerie) {
            $word = new Word();
            $word->setContent($wordsSerie2A[$key]);
            $word->setDefinition($this->definition->generateDefinition($word->getContent()));
            $this->addReference('letter_a_serie_2_word_' . $key, $word);
            $word->setSerie($this->getReference('serie_a_2'));
            $word->setPronunciation($pronunciationSerie2A[$key]);
            $manager->persist($word);
        }
        /*$word->setContent('haricot');
        $word->setDefinition($this->definition->generateDefinition($word->getContent()));
        $word->setCreatedAt(new DateTime());
        $this->addReference('word_haricot', $word);
        $word->setPronunciation($this->getReference('pronunciation_table'));
        $manager->persist($word);

        $word2 = new Word();
        $word2->setContent('banc');
        $word2->setDefinition($this->definition->generateDefinition($word2->getContent()));
        $word2->setCreatedAt(new DateTime());
        $this->addReference('word_banc', $word2);
        $word2->setPronunciation($this->getReference('pronunciation_ambulance'));
        $manager->persist($word2);

        $word3 = new Word();
        $word3->setContent('pain');
        $word3->setDefinition($this->definition->generateDefinition($word3->getContent()));
        $word3->setCreatedAt(new DateTime());
        $this->addReference('word_pain', $word3);
        $word3->setPronunciation($this->getReference('pronunciation_pain'));
        $manager->persist($word3);

        $word4 = new Word();
        $word4->setContent('jambe');
        $word4->setDefinition($this->definition->generateDefinition($word4->getContent()));
        $word4->setCreatedAt(new DateTime());
        $this->addReference('word_jambe', $word4);
        $word4->setPronunciation($this->getReference('pronunciation_ambulance'));
        $manager->persist($word4);

        $word5 = new Word();
        $word5->setContent('ail');
        $word5->setDefinition($this->definition->generateDefinition($word5->getContent()));
        $word5->setCreatedAt(new DateTime());
        $this->addReference('word_ail', $word5);
        $word5->setPronunciation($this->getReference('pronunciation_rail'));
        $manager->persist($word5);

        $word6 = new Word();
        $word6->setContent('cadeau');
        $word6->setDefinition($this->definition->generateDefinition($word6->getContent()));
        $word6->setCreatedAt(new DateTime());
        $this->addReference('word_cadeau', $word6);
        $word6->setPronunciation($this->getReference('pronunciation_chaussure'));
        $manager->persist($word6);

        $word7 = new Word();
        $word7->setContent('papa');
        $word7->setDefinition($this->definition->generateDefinition($word7->getContent()));
        $word7->setCreatedAt(new DateTime());
        $this->addReference('word_papa', $word7);
        $word7->setPronunciation($this->getReference('pronunciation_table'));
        $manager->persist($word7);*/

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PronunciationFixtures::class,
            SerieFixtures::class,
        ];
    }
}
