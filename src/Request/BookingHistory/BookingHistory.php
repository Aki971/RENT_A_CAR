<?php

declare(strict_types=1);

namespace App\Request\BookingHistory;

use App\DTO\RequestParams\BookingHistoryParams;
use App\Request\Field\Guid;
use App\Request\Field\UserGuid;
use App\Request\Field\VehicleGuid;
use App\Request\Field\BookingStart;
use App\Request\Field\BookingEnd;
use App\Request\Field\Approved;


interface BookingHistory extends
    Guid,
    UserGuid,
    VehicleGuid,
    BookingStart,
    BookingEnd,
    Approved
{
    public function params(): BookingHistoryParams;
}
