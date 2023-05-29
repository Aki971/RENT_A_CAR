<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

class VehicleParams
{
    public function __construct(
        public readonly string $make,
        public readonly string $model,
        public readonly int $price,
        public readonly string $description,
        public readonly string $image
    ) {
    }
}
