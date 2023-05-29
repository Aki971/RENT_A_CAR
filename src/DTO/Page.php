<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class Page implements JsonSerializable
{
    public function __construct(
        public readonly string $guid,
        public readonly string $title,
        public readonly string $content,
        public readonly string $image,
        public readonly DateTimeImmutable $createdAt,
        public readonly ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid' => $this->guid,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}
