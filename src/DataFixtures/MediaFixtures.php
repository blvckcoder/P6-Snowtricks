<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $trickReference = 'trick_' . $i;
            $trick = $this->getReference($trickReference);

            $media = new Media();
            $media->setType("image");
            $media->setUrl("trick_{$i}.jpg");
            $media->setTrick($trick);

            $manager->persist($media);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
        ];
    }
}

