<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $pwd = 'test';

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user = (new User())
            ->setFirstname($faker->name)
            ->setLastname($faker->name)
            ->setEmail('dev@user')
            ->setRoles([]);
        $user->setPassword($this->hasher->hashPassword($user, $this->pwd));
        $manager->persist($user);

        $user = (new User())
            ->setFirstname($faker->name)
            ->setLastname($faker->name)
            ->setEmail('dev@admin')
            ->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->hasher->hashPassword($user, $this->pwd));
        $manager->persist($user);


        for ($i = 0; $i < 10; $i++) {
            $object = (new User())
                ->setFirstname($faker->name)
                ->setLastname($faker->name)
                ->setEmail($faker->email)
                ->setRoles([])
            ;
            $object->setPassword($this->hasher->hashPassword($user, $this->pwd));
            $manager->persist($object);
        }

        $manager->flush();
    }
}
