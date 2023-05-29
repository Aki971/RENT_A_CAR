<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

use DateTime;

class LoginUserParams
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
