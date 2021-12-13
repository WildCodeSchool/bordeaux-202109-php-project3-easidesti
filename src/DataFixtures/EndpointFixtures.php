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
        $endpoint->setWord($this->getReference('word_haricot'));
        $endpoint->setPosition(2);
        $endpoint->setCreatedAt(new DateTime());
        $manager->persist($endpoint);

        $endpoint1 = new Endpoint();
        $endpoint1->setWord($this->getReference('word_haricot'));
        $endpoint1->setPosition(4);
        $endpoint1->setCreatedAt(new DateTime());
        $manager->persist($endpoint1);

        $endpoint2 = new Endpoint();
        $endpoint2->setWord($this->getReference('word_haricot'));
        $endpoint2->setPosition(7);
        $endpoint2->setCreatedAt(new DateTime());
        $manager->persist($endpoint2);

        $endpoint3 = new Endpoint();
        $endpoint3->setWord($this->getReference('word_banc'));
        $endpoint3->setPosition(4);
        $endpoint3->setCreatedAt(new DateTime());
        $manager->persist($endpoint3);

        $endpoint4 = new Endpoint();
        $endpoint4->setWord($this->getReference('word_pain'));
        $endpoint4->setPosition(4);
        $endpoint4->setCreatedAt(new DateTime());
        $manager->persist($endpoint4);

        $endpoint5 = new Endpoint();
        $endpoint5->setWord($this->getReference('word_jambe'));
        $endpoint5->setPosition(3);
        $endpoint5->setCreatedAt(new DateTime());
        $manager->persist($endpoint5);

        $endpoint6 = new Endpoint();
        $endpoint6->setWord($this->getReference('word_jambe'));
        $endpoint6->setPosition(5);
        $endpoint6->setCreatedAt(new DateTime());
        $manager->persist($endpoint6);

        $endpoint7 = new Endpoint();
        $endpoint7->setWord($this->getReference('word_ail'));
        $endpoint7->setPosition(3);
        $endpoint7->setCreatedAt(new DateTime());
        $manager->persist($endpoint7);

        $endpoint8 = new Endpoint();
        $endpoint8->setWord($this->getReference('word_cadeau'));
        $endpoint8->setPosition(2);
        $endpoint8->setCreatedAt(new DateTime());
        $manager->persist($endpoint8);

        $endpoint9 = new Endpoint();
        $endpoint9->setWord($this->getReference('word_cadeau'));
        $endpoint9->setPosition(6);
        $endpoint9->setCreatedAt(new DateTime());
        $manager->persist($endpoint9);


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            WordFixtures::class,
        ];
    }
}
