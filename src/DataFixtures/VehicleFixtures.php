<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public const VEHICLE_MAKE = ["BMW", "Audi", "Volkswagen"];
    private const VEHICLE_MODEL = ["530d", "A6", "Golf 7"];
    private const VEHICLE_DESCRIPTION = ["530d", "A6", "Golf 7"];
    private const VEHICLE_PRICE = [17,15,10];

    public function load(ObjectManager $manager): void
    {
        $vehicleManager = $this->createVehicle(0);
        $manager->persist($vehicleManager);
        $manager->flush();

        for ($i = 1; $i < count(self::VEHICLE_MAKE); $i++) {
            $vehicle = $this->createVehicle($i);
            $manager->persist($vehicle);
        }
        $manager->flush();
    }

    private function createVehicle(int $index): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setMake(self::VEHICLE_MAKE[$index])
             ->setModel(self::VEHICLE_MODEL[$index])
             ->setPrice(self::VEHICLE_PRICE[$index])
             ->setDescription(self::VEHICLE_DESCRIPTION[$index])
             ->setImage('https://www.lamborghini.com/sites/it-en/files/DAM/lamborghini/facelift_2019/homepage/families-gallery/2023/revuelto/revuelto_m.png');

        return $vehicle;
    }

}