<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use App\Entity\Serie;
use App\Entity\Word;
use App\Service\CsvHandler;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CsvFixtures extends Fixture implements DependentFixtureInterface
{
    private CsvHandler $csvHandler;

    public const LETTER_REFERENCES = [
        'a' => 6,
        'e' => 8,
        's' => 4,
        'i' => 6,
    ];

    public function __construct(CsvHandler $csvHandler)
    {
        $this->csvHandler = $csvHandler;
    }

    public function load(ObjectManager $manager): void
    {
        $csvData = $this->csvHandler->buildData();
        foreach ($csvData as $letterLevel => $series) {
            foreach ($series as $serieName => $words) {
                $number = str_replace('série ', '', $serieName);
                $serie = new Serie();
                $serie->setNumber((int)$number)
                    ->setLevel($letterLevel[1])
                    ->setLetter($this->getReference('letter_' . $letterLevel[0]));
                $manager->persist($serie);
                foreach ($words as $wordFromCsv) {
                    $word = new Word();
                    $word->setContent($wordFromCsv)
                        ->setSerie($serie)
                        ->setDefinition('À définir')
                        ->setLetter($this->getReference('letter_' . $letterLevel[0]))
                        ->setPronunciation($this->getReference('pronunciation_ambulance'));
                    $manager->persist($word);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PronunciationFixtures::class,
            LetterFixtures::class,
        ];
    }
}
