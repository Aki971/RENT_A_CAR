<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class Vehicle implements JsonSerializable
{
    public function __construct(
        public readonly string $guid,
        public readonly string $make,
        public readonly string $model,
        public readonly int $price,
        public readonly string $image,
        public readonly string $description,
        public readonly DateTimeImmutable $createdAt,
        public readonly ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'make' => $this->make,
            'model' => $this->model,
            'price' => $this->price,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}
