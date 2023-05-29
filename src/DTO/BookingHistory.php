<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class BookingHistory implements JsonSerializable
{
    public function __construct(
        public readonly string $guid,
        public readonly User $user,
        public readonly Vehicle $vehicle,
        public readonly DateTimeImmutable $bookingStart,
        public readonly DateTimeImmutable $bookingEnd,
        public readonly bool $approved,
        public readonly DateTimeImmutable $createdAt,
        public readonly ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'user' => $this->user,
            'vehicle' => $this->vehicle,
            'bookingStart' => $this->bookingStart,
            'bookingEnd' => $this->bookingEnd,
            'approved' => $this->approved,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
