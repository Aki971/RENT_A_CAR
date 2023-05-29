<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Vehicles;
use App\DTO\Vehicle as VehicleDTO;
use App\Query\VehicleInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class Vehicle implements VehicleInterface
{
    private const SELECT_QUERY = [
        'v.guid as vehicle_guid',
        'v.make as vehicle_make',
        'v.model as vehicle_model',
        'v.price as vehicle_price',
        'v.image as vehicle_image',
        'v.image as vehicle_description',
        'v.created_at as vehicle_created_at',
        'v.updated_at as vehicle_updated_at',
    ];

    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): Vehicles
    {
        $vehiclesData = $this->connection->createQueryBuilder('vehicles')
            ->select(self::SELECT_QUERY)
            ->from('vehicles', 'v')
            ->orderBy('v.make', 'ASC')
            ->fetchAllAssociative();

        return new Vehicles(array_map(fn(array $vehicleData) => $this->createVehicleDTO($vehicleData), $vehiclesData));
    }

    public function getByGuid(string $guid): ?VehicleDTO
    {
        $vehicleData = $this->connection->createQueryBuilder()
            ->select(self::SELECT_QUERY)
            ->from('vehicles', 'v')
            ->where('v.guid = :guid')
            ->setParameter('guid', $guid)
            ->fetchAssociative();

        if (false === $vehicleData) {
            return null;
        }

        return $this->createVehicleDTO($vehicleData);
    }

    private function createVehicleDTO(array $vehicleData): VehicleDTO
    {
        return new VehicleDTO(
            $vehicleData['vehicle_guid'],
            $vehicleData['vehicle_make'],
            $vehicleData['vehicle_model'],
            $vehicleData['vehicle_price'],
            $vehicleData['vehicle_image'],
            $vehicleData['vehicle_description'],
            new DateTimeImmutable($vehicleData['vehicle_created_at']),
            $vehicleData['vehicle_updated_at'] ? new DateTime($vehicleData['vehicle_updated_at']) : null,
        );
    }
}
