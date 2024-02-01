<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Effect;

class EffectFixtures extends Fixture
{
    public const EFFECT = [
        ['name' => 'Potion', 'description' => 'An effect for your drinking potion animation',
        'picture' => 'potion.png'],
        ['name' => 'Smoke', 'description' => 'Where there\'s smoke, there\'s a fire',
        'picture' => 'smoke.png'],
        ['name' => 'Explosion', 'description' => 'Explosions, explosions everywhere!!!!',
        'picture' => 'explosion.png']
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadEffectDir = '/uploads/effect';

        if (!is_dir(__DIR__ . '/../../public' . $uploadEffectDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadEffectDir, recursive: true);
        }

        foreach (self::EFFECT as $effectData) {
            copy(
                __DIR__ . '/data/effect/' . $effectData['picture'],
                __DIR__ . '/../../public' . $uploadEffectDir . '/' . $effectData['picture']
            );

            $effect = new Effect();
            $effect->setName($effectData['name']);
            $effect->setDescription($effectData['description']);
            $effect->setPicture($effectData['picture']);
            $manager->persist($effect);

            $manager->flush();
        }
    }
}
