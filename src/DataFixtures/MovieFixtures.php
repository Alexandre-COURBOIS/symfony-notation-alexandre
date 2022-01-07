<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $choice = [0 => 'Serie', 1 => 'Film'];

        for ($i = 0; $i <= 50; $i++) {

            $faker = Faker\Factory::create('FR-fr');
            $video = new Video();
            $video->setNom($faker->name);
            $video->setSynopsis($faker->text(max(150,150)));
            $video->setType($choice[rand(0,1)]);

            $manager->persist($video);
        }

        $manager->flush();
    }
}
