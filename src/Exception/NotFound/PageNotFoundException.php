<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class PageNotFoundException extends NotFoundException
{
    public function __construct(readonly string $pageGuid)
    {
        parent::__construct($pageGuid, 'page');
    }
}
