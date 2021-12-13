<?php

namespace App\DataFixtures;

use App\Entity\MuteLetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class MuteLetterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $muteLetter = new MuteLetter();
        $muteLetter->setWord($this->getReference('word_haricot'));
        $muteLetter->setPosition(1);
        $muteLetter->setCreatedAt(new DateTime());
        $manager->persist($muteLetter);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
