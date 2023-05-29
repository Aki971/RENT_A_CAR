<?php

declare(strict_types=1);

namespace App\Enum;

enum Role: string
{
    case ADMIN = 'admin';
    case PUBLIC = 'public';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}