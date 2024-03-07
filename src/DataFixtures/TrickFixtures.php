<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    private const TRICK_NAMES = [
        'Ollie',
        'Butter',
        'Nose Press',
        'Tail Press',
        'Indy',
        'Nollie',
        'Kickflip',
        '540 Spin',
        'Backflip',
        'Frontflip'
    ];

    private const CATEGORIES = [
        'Butter',
        'Grabs',
        'Flips',
        'Spins',
        'Corks',
        'Rails',
        'Slides',
        'Boxes'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TRICK_NAMES as $i => $name) {
            $trick = new Trick();
            $trick->setName($name);
            $trick->setDescription("A description for $name");
            $trick->setSlug(strtolower(str_replace(' ', '-', $name)));
            $trick->setCreatedAt(new \DateTimeImmutable());

            $categoryReference = 'category_' . self::CATEGORIES[$i % count(self::CATEGORIES)];
            $trick->setCategory($this->getReference($categoryReference));

            $userReference = match ($i % 3) {
                0 => UserFixtures::ADMIN_REFERENCE,
                1 => UserFixtures::USER1_REFERENCE,
                2 => UserFixtures::USER2_REFERENCE,
            };
            $trick->setAuthor($this->getReference($userReference));

            $manager->persist($trick);

            $this->addReference('trick_' . ($i + 1), $trick);
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
