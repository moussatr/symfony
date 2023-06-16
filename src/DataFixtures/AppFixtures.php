<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Carcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
for ($i = 0; $i < 100; $i++ ){
    $category = new Carcategory();
        $category->setName('Berline');

        $car = new Car();
        $car->setName('Range Rover' . $i);
        $car->setNbSeats(mt_rand(2, 6));
        $car->setNbDoors(mt_rand(2, 6));
        $car->setCost(mt_rand(123.56, 576.56));
        $car->setCategory($category);

        $manager->persist($category);
        $manager->persist($car);

}
        

      

        $manager->flush();
    }
}
