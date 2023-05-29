<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class HistoryNotFoundException extends NotFoundException
{
    public function __construct(readonly string $userGuid)
    {
        parent::__construct($userGuid, 'history');
    }
}
