<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class Pages implements JsonSerializable
{
    public function __construct(
        public readonly array $pages
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->pages;
    }
}
