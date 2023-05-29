<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

use DateTime;

class BookingHistoryParams
{
    public function __construct(
        public readonly string $userGuid,
        public readonly string $vehicleGuid,
        public readonly string $bookingStart,
        public readonly string $bookingEnd,
        public readonly bool $approved,
    ) {
    }
}
