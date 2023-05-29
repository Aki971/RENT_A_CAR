<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Pages;
use App\DTO\Page;

interface PageInterface
{
    public function getAll(): Pages;

    public function getByGuid(string $guid): ?Page;

}
