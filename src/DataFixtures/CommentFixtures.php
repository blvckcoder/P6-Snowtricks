<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $trickReference = 'trick_' . $i;
            $trick = $this->getReference($trickReference);

            $userReference = ($i % 2 == 0) ? UserFixtures::USER1_REFERENCE : UserFixtures::USER2_REFERENCE;
            $user = $this->getReference($userReference);

            $comment = new Comment();
            $comment->setContent("Impressive trick number $i!");
            $comment->setTrick($trick);
            $comment->setAuthor($user);
            $comment->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
            UserFixtures::class,
        ];
    }
}

