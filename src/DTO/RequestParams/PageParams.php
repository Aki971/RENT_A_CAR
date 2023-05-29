<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

class PageParams
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $image
    ) {
    }
}
