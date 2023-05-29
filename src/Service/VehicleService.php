<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Collection\Vehicles;
use App\DTO\RequestParams\VehicleParams;
use App\DTO\Vehicle as VehicleDTO;
use App\Entity\Vehicle;
use App\Exception\NotFound\VehicleNotFoundException;
use App\Query\VehicleInterface;
use App\Repository\VehicleRepository;
use App\Enum\Role;
use DateTime;
use Ramsey\Uuid\Nonstandard\Uuid;

class VehicleService
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
        private readonly VehicleInterface $vehicleQuery,
    ) {
    }

    public function getAll(): Vehicles
    {
        return $this->vehicleQuery->getAll();
    }

    public function get(string $guid): VehicleDTO
    {
        $vehicle = $this->vehicleQuery->getByGuid($guid);

        if (null === $vehicle) {
            throw new VehicleNotFoundException($guid);
        }

        return $vehicle;
    }

    public function create(VehicleParams $params): string
    {
        $vehicle = $this->vehicleRepository->getEntityInstance();
        $vehicle->update($params);
        $this->vehicleRepository->save($vehicle);

        return $vehicle->getGuid();
    }

    public function updateByGuid(string $guid, VehicleParams $params): void
    {
        $vehicle = $this->findVehicle($guid);
        $vehicle->update($params);

        $this->vehicleRepository->save($vehicle);
    }

    public function deleteByGuid(string $guid): void
    {
        $vehicle = $this->findVehicle($guid);

        $this->vehicleRepository->remove($vehicle);
    }

    private function findVehicle(string $guid): Vehicle
    {
        $vehicle = $this->vehicleRepository->find($guid);

        if (null === $vehicle) {
            throw new VehicleNotFoundException($guid);
        }

        return $vehicle;
    }
}
