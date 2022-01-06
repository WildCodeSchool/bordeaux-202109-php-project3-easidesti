<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class LetterFixtures extends Fixture
{
    public const LETTER_REFERENCES = [
        'a' => 6,
        'e' => 8,
        's' => 4,
        'i' => 6,
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::LETTER_REFERENCES as $letterKey => $nbProposal) {
            $letter = new Letter();
            $letter->setContent($letterKey);
            $letter->setNbProposal($nbProposal);
            $this->addReference('letter_' . $letterKey, $letter);
            $manager->persist($letter);
        }

        $manager->flush();
    }
}
