<?php

namespace App\DataFixtures;

use App\Entity\Festival;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FestivalFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < 10; $i++) {
            $object = (new Festival())
                ->setName($faker->colorName)
                ->setBeginAt(new \DateTime())
                ->setEndAt(new \DateTime())
                ->setCreatedAt(new \DateTime())
            ;

            $manager->persist($object);
        }

        $manager->flush();
    }
}
