<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\BookingHistorys;
use App\DTO\BookingHistory;

interface BookingHistoryInterface
{
    public function getAll(): BookingHistorys;

    public function getByGuid(string $guid): ?BookingHistory;

    public function getHistoryByUser(string $guid): BookingHistorys;
}
