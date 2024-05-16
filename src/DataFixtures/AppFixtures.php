<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
     $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        for($i=0; $i<50; $i++){
        $vehicle = new Vehicle();
        $vehicle->setBrand($this->faker->word())
            ->setModel($this->faker->word());

        $manager->persist($vehicle);
        }
        $manager->flush();
    }
}
