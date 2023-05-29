<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class Users implements JsonSerializable
{
    public function __construct(
        public readonly array $users
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->users;
    }
}
