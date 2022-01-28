<?php

namespace App\DataFixtures;

use App\Entity\School;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $school = new School();
         $school->setName('Wild Code School');
         $this->addReference('Wild Code School', $school);
         $manager->persist($school);

         $school2 = new School();
         $school2->setName('Poudlard');
         $this->addReference('Poudlard', $school2);
         $manager->persist($school2);

         $school3 = new School();
         $school3->setName('Beauxbâtons');
         $this->addReference('Beauxbâtons', $school3);
         $manager->persist($school3);

         $manager->flush();
    }
}
