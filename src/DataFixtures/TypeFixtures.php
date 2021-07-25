<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Type;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = [
            'Anime',
            'Série',
            'Manga',
            'BD',
            'Comics'
        ];

        foreach ( $types as $type )
        {
            $data = new Type();
            $data->setName($type);
            $manager->persist($data);
        }

        $manager->flush();
    }
}
