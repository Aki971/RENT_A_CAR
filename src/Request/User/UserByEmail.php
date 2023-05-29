<?php

declare(strict_types=1);

namespace App\Request\User;

use App\DTO\RequestParams\UserByEmailParams;
use App\Request\Field\Email;

interface UserByEmail extends Email
{
    public function params(): UserByEmailParams;
}
