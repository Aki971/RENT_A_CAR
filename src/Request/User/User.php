<?php

declare(strict_types=1);

namespace App\Request\User;

use App\DTO\RequestParams\UserParams;
use App\Request\Field\Email;
use App\Request\Field\Name;
use App\Request\Field\Guid;
use App\Request\Field\Image;
use App\Request\Field\Password;
use App\Request\Field\LastName;
use App\Request\Field\Role;

interface User extends
    Guid,
    Name,
    LastName,
    Email,
    Password,
    Role,
    Image
{
    public function params(): UserParams;
}