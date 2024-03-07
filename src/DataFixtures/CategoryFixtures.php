<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Butter' => 'Butter tricks involve a smooth and flowing style, often incorporating flat ground spins and edge control.',
        'Grabs' => 'Grabs are tricks performed by grabbing the skateboard, typically while the skateboarder is airborne.',
        'Flips' => 'Flip tricks are a subset of aerials which are all based on the ollie, but also involve the skateboard flipping in some way.',
        'Spins' => 'Spins involve the skateboarder rotating with the board in the air; this can range from 180s to 1080s or more.',
        'Corks' => 'Corkscrew maneuvers that involve off-axis spins, typically performed in freestyle snowboarding.',
        'Rails' => 'Rail tricks involve sliding along a rail or similar long, narrow surface, using the skateboard trucks or the bottom of the board.',
        'Slides' => 'Any trick where the skateboarder slides sideways either on the deck or on the wheels along an obstacle.',
        'Boxes' => 'Box tricks are performed on a box-shaped obstacle, combining elements of slides, grinds, and sometimes flips.'
    ];    

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $name => $description) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);
            $manager->persist($category);

            $this->addReference('category_' . $name, $category);
        }

        $manager->flush();
    }
}
