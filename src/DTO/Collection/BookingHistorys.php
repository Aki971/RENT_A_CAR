<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class BookingHistorys implements JsonSerializable
{
    public function __construct(
        public readonly array $bookingHistorys
    ) {
    }

    public function jsonSerialize()
    {
        return $this->bookingHistorys;
    }
}
