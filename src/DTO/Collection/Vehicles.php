<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class Vehicles implements JsonSerializable
{
    public function __construct(
        public readonly array $vehicles
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->vehicles;
    }
}
