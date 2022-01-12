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

    public const POSITION_TEST_1 = [
        [
          'letter' => 'e',
          'number' => 16,
          'level'  => 2,
        ],
        [
            'letter' => 'a',
            'number' => 10,
            'level'  => 2,
        ],
        [
            'letter' => 's',
            'number' => 6,
            'level'  => 2,
        ],
        [
            'letter' => 'i',
            'number' => 13,
            'level'  => 2,
        ],
    ];

    public const POSITION_TEST_2 = [
        [
            'letter' => 'e',
            'number' => 17,
            'level'  => 2,
        ],
        [
            'letter' => 'a',
            'number' => 11,
            'level'  => 2,
        ],
        [
            'letter' => 's',
            'number' => 7,
            'level'  => 2,
        ],
        [
            'letter' => 'i',
            'number' => 14,
            'level'  => 2,
        ],
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
                foreach (self::POSITION_TEST_1 as $testData) {
                    if ($testData['letter'] === $letterLevel[0]
                        && $testData['number'] === $serie->getNumber()
                        && $testData['level'] === $serie->getLevel()) {
                        $serie->setPositionTest(1);
                    }
                }
                foreach (self::POSITION_TEST_2 as $testData) {
                    if ($testData['letter'] === $letterLevel[0]
                        && $testData['number'] === $serie->getNumber()
                        && $testData['level'] === $serie->getLevel()) {
                        $serie->setPositionTest(2);
                    }
                }
                $manager->persist($serie);
                foreach ($words as $wordFromCsv) {
                    $word = new Word();
                    $word->setContent($wordFromCsv)
                        ->setSerie($serie)
                        ->setDefinition(Serie::NO_DEFINITION)
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
