<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Vehicles;
use App\DTO\Vehicle;

interface VehicleInterface
{
    public function getAll(): Vehicles;

    public function getByGuid(string $guid): ?Vehicle;

}
