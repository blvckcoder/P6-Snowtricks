<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public const ADMIN_REFERENCE = 'admin';
    public const USER1_REFERENCE = 'user1';
    public const USER2_REFERENCE = 'user2';

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('Blvckcoder')
        ->setEmail('dev@blvckcoder.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setProfilePicture('blvckcoder.jpeg')
        ->setIsVerified(true)
        ->setPassword($this->passwordHasher->hashPassword($admin, '0000'))
        ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($admin);

        $user1 = new User();
        $user1->setUsername('John Snow')
        ->setEmail('user1@mail.com')
        ->setRoles(['ROLE_USER'])
        ->setProfilePicture('avatar.jpeg')
        ->setIsVerified(true)
        ->setPassword($this->passwordHasher->hashPassword($user1, '0000'))
        ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('Bobby Brown')
        ->setEmail('user2@mail.com')
        ->setRoles(['ROLE_USER'])
        ->setProfilePicture('avatar.jpeg')
        ->setIsVerified(true)
        ->setPassword($this->passwordHasher->hashPassword($user2, '0000'))
        ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user2);


        $manager->flush();

        $this->addReference(self::ADMIN_REFERENCE, $admin);
        $this->addReference(self::USER1_REFERENCE, $user1);
        $this->addReference(self::USER2_REFERENCE, $user2);
    }
}
