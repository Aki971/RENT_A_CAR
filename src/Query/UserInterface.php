<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Users;
use App\DTO\User;

interface UserInterface
{
    public function getAll(): Users;

    public function getByGuid(string $guid): ?User;

    public function getByEmail(string $email): ?User;

}
