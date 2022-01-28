<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setNickname('eleve1');
        $user->setFirstname('Greg');
        $user->setLastname('Caron');
        $user->setSchoolLevel($this->getReference('Wild CM1'));
        $user->setRoles(['ROLE_STUDENT']);
        $user->setHasTest(false);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'azerty'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $user2 = new User();
        $user2->setNickname('Panpan');
        $user2->setFirstname('Sébastien');
        $user2->setLastname('Juchet');
        $user2->setSchoolLevel($this->getReference('Wild CM1'));
        $user2->setRoles(['ROLE_STUDENT']);
        $user2->setHasTest(true);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user2,
            'azerty'
        );
        $user2->setPassword($hashedPassword);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setNickname('Machine');
        $user3->setFirstname('Olivier');
        $user3->setLastname('Chatelin');
        $user3->setSchool($this->getReference('Beauxbâtons'));
        $user3->setSchoolLevel('CM2');
        $user3->setRoles(['STUDENT']);
        $user3->setHasTest(true);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user3,
            'azerty'
        );
        $user3->setPassword($hashedPassword);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setNickname('Bambi');
        $user4->setFirstname('Guillaume');
        $user4->setLastname('Harari');
        $user4->setSchool($this->getReference('Poudlard'));
        $user4->setSchoolLevel('CM1');
        $user4->setRoles(['STUDENT']);
        $user4->setHasTest(true);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user4,
            'azerty'
        );
        $user4->setPassword($hashedPassword);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setNickname('Karim');
        $user5->setFirstname('Karine');
        $user5->setLastname('Laurent');
        $user5->setSchool($this->getReference('Wild Code School'));
        $user5->setSchoolLevel('CM1');
        $user5->setRoles(['STUDENT']);
        $user5->setHasTest(true);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user5,
            'azerty'
        );
        $user5->setPassword($hashedPassword);
        $manager->persist($user5);

        $admin = new User();
        $admin->setNickname('Odile');
        $admin->setFirstname('Odile');
        $admin->setLastname('Amadou');
        $admin->setRoles(['ROLE_ADMIN']);
        $user2->setHasTest(false);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'azerty'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SchoolLevelFixtures::class];
    }
}
