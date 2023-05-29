<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\Role;
use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class User implements JsonSerializable
{
    public function __construct(
        public readonly string $guid,
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly Role $role,
        public readonly string $image,
        public readonly DateTimeImmutable $createdAt,
        public readonly ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'name' => $this->name,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}
