<?php

declare(strict_types=1);

namespace App\Request\User;

use App\DTO\RequestParams\LoginUserParams;
use App\Request\Field\Email;
use App\Request\Field\Password;

interface LoginUser extends
    Email,
    Password
{
    public function params(): LoginUserParams;
}