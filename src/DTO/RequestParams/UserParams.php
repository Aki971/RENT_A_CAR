<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

use App\Enum\Role;

class UserParams
{
    public function __construct(
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly Role $role,
        public readonly string $image
    ) {
    }
}
