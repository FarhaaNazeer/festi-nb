<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Festival;
use Faker\Factory;

class FestivalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {

            $festival = (new Festival())
                            ->setName($faker->colorName)
                            ->setBeginAt($faker->dateTime)
                            ->setEndAt($faker->dateTime)
                            ->setCity($faker->city)
                            ->setCountry($faker->country)
                            ->setDescription($faker->text)
                            ->setShortDescription($faker->text)
            ;

            $manager->persist($festival);
        }
        $manager->flush();
    }
}
