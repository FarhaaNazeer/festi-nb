<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {

            $ticket = (new Ticket())
                            ->setTitle('Pass '.$faker->colorName)
                            ->setStartDate($faker->dateTime)
                            ->setEndDate($faker->dateTime)
                            ->setPrice($faker->numberBetween(25, 200))
                            ->setIsExpired(false)
                            ->setDescription($faker->text(50))
            ;

            $manager->persist($ticket);
        }
        $manager->flush();
    }
}
