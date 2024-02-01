<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Background;

class BackgroundFixtures extends Fixture
{
    public const BACKGROUND = [
        ['name' => 'Old Town', 'description' => 'A small and old town nested in the mountains',
         'picture' => 'wood_city.png'],
        ['name' => 'Forest Town', 'description' => 'It is said gnomes live here, in the heart of the forest',
        'picture' => 'forest.png'],
        ['name' => 'Outer Space', 'description' => 'Bip bip boup biiiip boup boup... end of transmission...',
        'picture' => 'space.png']
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadBackgroundDir = '/uploads/background';

        if (!is_dir(__DIR__ . '/../../public' . $uploadBackgroundDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadBackgroundDir, recursive: true);
        }

        foreach (self::BACKGROUND as $backgroundData) {
            copy(
                __DIR__ . '/data/background/' . $backgroundData['picture'],
                __DIR__ . '/../../public' . $uploadBackgroundDir . '/' . $backgroundData['picture']
            );

            $background = new Background();
            $background->setName($backgroundData['name']);
            $background->setDescription($backgroundData['description']);
            $background->setPicture($backgroundData['picture']);
            $manager->persist($background);

            $manager->flush();
        }
    }
}
