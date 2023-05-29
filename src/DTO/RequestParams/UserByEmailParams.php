<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

class UserByEmailParams
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
