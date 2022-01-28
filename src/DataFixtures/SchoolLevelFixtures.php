<?php

namespace App\DataFixtures;

use App\Entity\SchoolLevel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SchoolLevelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $schoolLevel = new SchoolLevel();
        $schoolLevel->setName('CM1');
        $schoolLevel->setSchool($this->getReference('Wild Code School'));
        $this->addReference('Wild CM1', $schoolLevel);
        $manager->persist($schoolLevel);

        $schoolLevel2 = new SchoolLevel();
        $schoolLevel2->setName('CM2');
        $schoolLevel2->setSchool($this->getReference('Wild Code School'));
        $this->addReference('Wild CM2', $schoolLevel2);
        $manager->persist($schoolLevel2);

        $schoolLevel3 = new SchoolLevel();
        $schoolLevel3->setName('6e');
        $schoolLevel3->setSchool($this->getReference('Wild Code School'));
        $this->addReference('Wild 6e', $schoolLevel3);

        $manager->persist($schoolLevel3);

        $schoolLevel4 = new SchoolLevel();
        $schoolLevel4->setName('CM1');
        $schoolLevel4->setSchool($this->getReference('Poudlard'));
        $this->addReference('Poudlard CM1', $schoolLevel4);
        $manager->persist($schoolLevel4);

        $schoolLevel5 = new SchoolLevel();
        $schoolLevel5->setName('CM2');
        $schoolLevel5->setSchool($this->getReference('Poudlard'));
        $this->addReference('Poudlard CM2', $schoolLevel5);
        $manager->persist($schoolLevel5);

        $schoolLevel9 = new SchoolLevel();
        $schoolLevel9->setName('6e');
        $schoolLevel9->setSchool($this->getReference('Poudlard'));
        $this->addReference('Poudlard 6e', $schoolLevel9);
        $manager->persist($schoolLevel9);

        $schoolLevel6 = new SchoolLevel();
        $schoolLevel6->setName('CM1');
        $schoolLevel6->setSchool($this->getReference('Beauxbâtons'));
        $this->addReference('Beauxbâtons CM1', $schoolLevel6);
        $manager->persist($schoolLevel6);

        $schoolLevel7 = new SchoolLevel();
        $schoolLevel7->setName('CM2');
        $schoolLevel7->setSchool($this->getReference('Beauxbâtons'));
        $this->addReference('Beauxbâtons CM2', $schoolLevel7);
        $manager->persist($schoolLevel7);

        $schoolLevel8 = new SchoolLevel();
        $schoolLevel8->setName('6e');
        $schoolLevel8->setSchool($this->getReference('Beauxbâtons'));
        $this->addReference('Beauxbâtons 6e', $schoolLevel8);
        $manager->persist($schoolLevel8);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SchoolFixtures::class];
    }
}
