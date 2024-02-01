<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Character;

class CharacterFixtures extends Fixture
{
    public const CHARACTER = [
        ['name' => 'Olympe', 'description' => 'She is a warrior princess, living in a castle 
        in the clouds', 'picture' => 'princess.png'],
        ['name' => 'Ragnar', 'description' => 'There\'s no viking more viking than Ragnar. 
        He will crush his enemies with his bare hands', 'picture' => 'ragnar.png'],
        ['name' => 'The Count', 'description' => 'The count is an old vampire. So old the 
        legends says Mammoth went extinct because of him.', 'picture' => 'thecount.png']
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadCharacterDir = '/uploads/character';

        if (!is_dir(__DIR__ . '/../../public' . $uploadCharacterDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadCharacterDir, recursive: true);
        }

        foreach (self::CHARACTER as $characterData) {
            copy(
                __DIR__ . '/data/character/' . $characterData['picture'],
                __DIR__ . '/../../public' . $uploadCharacterDir . '/' . $characterData['picture']
            );

            $character = new Character();
            $character->setName($characterData['name']);
            $character->setDescription($characterData['description']);
            $character->setPicture($characterData['picture']);
            $manager->persist($character);

            $manager->flush();
        }
    }
}
