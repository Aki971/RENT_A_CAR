<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class VehicleNotFoundException extends NotFoundException
{
    public function __construct(readonly string $vehicleGuid)
    {
        parent::__construct($vehicleGuid, 'vehicle');
    }
}
