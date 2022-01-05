<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Endpoint;
use DateTime;

class EndpointFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $endpoint = new Endpoint();
        $endpoint->setWord($this->getReference('letter_a_serie_1_word_0'));
        $endpoint->setPosition(2);
        $manager->persist($endpoint);

        $endpoint1 = new Endpoint();
        $endpoint1->setWord($this->getReference('letter_a_serie_1_word_0'));
        $endpoint1->setPosition(5);
        $manager->persist($endpoint1);

        $endpoint2 = new Endpoint();
        $endpoint2->setWord($this->getReference('letter_a_serie_1_word_1'));
        $endpoint2->setPosition(1);
        $manager->persist($endpoint2);

        $endpoint3 = new Endpoint();
        $endpoint3->setWord($this->getReference('letter_a_serie_1_word_1'));
        $endpoint3->setPosition(3);
        $manager->persist($endpoint3);

        $endpoint4 = new Endpoint();
        $endpoint4->setWord($this->getReference('letter_a_serie_1_word_2'));
        $endpoint4->setPosition(1);
        $manager->persist($endpoint4);

        $endpoint5 = new Endpoint();
        $endpoint5->setWord($this->getReference('letter_a_serie_1_word_2'));
        $endpoint5->setPosition(3);
        $manager->persist($endpoint5);

        $endpoint6 = new Endpoint();
        $endpoint6->setWord($this->getReference('letter_a_serie_1_word_3'));
        $endpoint6->setPosition(1);
        $manager->persist($endpoint6);

        $endpoint7 = new Endpoint();
        $endpoint7->setWord($this->getReference('letter_a_serie_1_word_3'));
        $endpoint7->setPosition(4);
        $manager->persist($endpoint7);

        $endpoint8 = new Endpoint();
        $endpoint8->setWord($this->getReference('letter_a_serie_1_word_4'));
        $endpoint8->setPosition(1);
        $manager->persist($endpoint8);

        $endpoint9 = new Endpoint();
        $endpoint9->setWord($this->getReference('letter_a_serie_1_word_4'));
        $endpoint9->setPosition(4);
        $manager->persist($endpoint9);

        $endpoint10 = new Endpoint();
        $endpoint10->setWord($this->getReference('letter_a_serie_1_word_5'));
        $endpoint10->setPosition(1);
        $manager->persist($endpoint10);

        $endpoint11 = new Endpoint();
        $endpoint11->setWord($this->getReference('letter_a_serie_1_word_5'));
        $endpoint11->setPosition(5);
        $manager->persist($endpoint11);

        $endpoint12 = new Endpoint();
        $endpoint12->setWord($this->getReference('letter_a_serie_1_word_6'));
        $endpoint12->setPosition(2);
        $manager->persist($endpoint12);

        $endpoint13 = new Endpoint();
        $endpoint13->setWord($this->getReference('letter_a_serie_1_word_7'));
        $endpoint13->setPosition(1);
        $manager->persist($endpoint13);

        $endpoint14 = new Endpoint();
        $endpoint14->setWord($this->getReference('letter_a_serie_1_word_8'));
        $endpoint14->setPosition(1);
        $manager->persist($endpoint14);

        $endpoint15 = new Endpoint();
        $endpoint15->setWord($this->getReference('letter_a_serie_1_word_8'));
        $endpoint15->setPosition(3);
        $manager->persist($endpoint15);

        $endpoint16 = new Endpoint();
        $endpoint16->setWord($this->getReference('letter_a_serie_1_word_8'));
        $endpoint16->setPosition(5);
        $manager->persist($endpoint16);

        $endpoint17 = new Endpoint();
        $endpoint17->setWord($this->getReference('letter_a_serie_1_word_9'));
        $endpoint17->setPosition(1);
        $manager->persist($endpoint17);

        $endpoint18 = new Endpoint();
        $endpoint18->setWord($this->getReference('letter_a_serie_1_word_9'));
        $endpoint18->setPosition(4);
        $manager->persist($endpoint18);

        $endpoint19 = new Endpoint();
        $endpoint19->setWord($this->getReference('letter_a_serie_1_word_10'));
        $endpoint19->setPosition(0);
        $manager->persist($endpoint19);

        $endpoint20 = new Endpoint();
        $endpoint20->setWord($this->getReference('letter_a_serie_1_word_10'));
        $endpoint20->setPosition(4);
        $manager->persist($endpoint20);

        $endpoint21 = new Endpoint();
        $endpoint21->setWord($this->getReference('letter_a_serie_1_word_11'));
        $endpoint21->setPosition(0);
        $manager->persist($endpoint21);

        $endpoint22 = new Endpoint();
        $endpoint22->setWord($this->getReference('letter_a_serie_1_word_11'));
        $endpoint22->setPosition(4);
        $manager->persist($endpoint22);

        $endpoint23 = new Endpoint();
        $endpoint23->setWord($this->getReference('letter_a_serie_1_word_12'));
        $endpoint23->setPosition(1);
        $manager->persist($endpoint23);

        $endpoint24 = new Endpoint();
        $endpoint24->setWord($this->getReference('letter_a_serie_1_word_12'));
        $endpoint24->setPosition(4);
        $manager->persist($endpoint24);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
