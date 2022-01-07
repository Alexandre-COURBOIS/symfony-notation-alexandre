<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher ;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('FR-fr');

        for ($i = 0; $i <= 10; $i++) {

            $user = new User();

            $user->setEmail($faker->email);

            $plainPassword = "Password@!76";

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plainPassword
            );

            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
